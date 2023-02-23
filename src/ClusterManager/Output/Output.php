<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Output;

use E32CM\ClusterManager\Main\ApplicationCommand\Commands\DisplayMessageCommand;
use E32CM\ClusterManager\Output\Drivers\OutputDriver;
use E32CM\ClusterManager\Output\Exception\InvalidScrollModeException;
use E32CM\ClusterManager\Output\Exception\NoMessageToDisplayException;

use function E32CM\DEBUG_logChar;

/**
 * ALL output drivers assume having only 16 characters capable of being displayed at the same time
 * because that is how many does E34/E32 cluster has
 */
class Output
{
    public const BUSY = 'BUSY';
    public const WAITING = 'WAITING';
    public const READY = 'READY';

    public const LIST_OF_SCROLLING_SPEEDS = [
        self::NO_SCROLLING,
        self::VERY_SLOW_SCROLLING,
        self::SLOW_SCROLLING,
        self::NORMAL_SCROLLING,
        self::FAST_SCROLLING,
        self::VERY_FAST_SCROLLING,
        self::PRESENTATION_SCROLLING
    ];

    /** every 1000 secs */
    public const NO_SCROLLING = 'NO_SCROLLING';
    /** every 2 secs */
    public const VERY_SLOW_SCROLLING = 'VERY_SLOW_SCROLLING';
    /** every 1,5 secs */
    public const SLOW_SCROLLING = 'SLOW_SCROLLING';
    /** every 1 sec */
    public const NORMAL_SCROLLING = 'NORMAL_SCROLLING';
    /** every 0,75 secs */
    public const FAST_SCROLLING = 'FAST_SCROLLING';
    /** every 0,5 secs */
    public const VERY_FAST_SCROLLING = 'VERY_FAST_SCROLLING';
    /** every 0,25 secs */
    public const PRESENTATION_SCROLLING = 'PRESENTATION_SCROLLING';


    private OutputDriver $outputDriver;

    private float $lastScrollTickTime;

    private string $currentAppState = self::READY;
    private string $currentScrollingSpeed = self::NO_SCROLLING;
    private ?int $currentScrollingPosition = 0;
    private ?string $currentMessage = null;

    private array $displayQueue = [];

    private bool $doTickTimeCheck = false;

    public function __construct(OutputDriver $outputDriver)
    {
        $this->outputDriver = $outputDriver;
        $this->lastScrollTickTime = microtime(true);
    }

    public function displayMessage(string $message, string $scrollMode, string $displayMode): void
    {
        if (!$this->isValidScrollMode($scrollMode)) {
            throw InvalidScrollModeException::createWithInvalidScrollMode($scrollMode);
        }

        if ($displayMode === DisplayMessageCommand::FORCE_DISPLAY) {
            $this->displayQueue = [];
            $this->currentMessage = $message;
            $this->currentScrollingSpeed = $scrollMode;
            $this->currentScrollingPosition = 0;
            $this->changeState(self::BUSY);
            return;
        }

        $this->displayQueue[] = ['message' => "   " . $message, 'scrollMode' => $scrollMode];
    }

    public function skipCurrentMessage(): void
    {
        $this->displayQueue = [];
        $this->currentMessage = null;
        $this->currentScrollingSpeed = self::NO_SCROLLING;
        $this->currentScrollingPosition = 0;
        $this->changeState(self::READY);
    }

    public function tick(): string
    {
        $this->doTickTimeCheck = true;
        try {
            $this->getMessageForThisTick();
        } catch (NoMessageToDisplayException $exception) {
            return $this->currentAppState;
        }

        if ($this->doTickTimeCheck) {
            $waitTime = constant(OutputTimeMapping::class . "::" . $this->currentScrollingSpeed);
            if ((microtime(true) - $this->lastScrollTickTime) < $waitTime) {
                usleep((int)($waitTime * 1000000));
                return $this->currentAppState;
            }
        }

        /** Has finished displaying? */
        if ($this->currentScrollingPosition === mb_strlen($this->currentMessage)) {
            $this->changeState(self::READY);
            DEBUG_logChar(PHP_EOL, null);
            return $this->currentAppState;
        }

        /** Do something */
        $this->changeState(self::BUSY);
        $finalMessage = mb_substr($this->currentMessage, $this->currentScrollingPosition, 16, 'UTF-8');
        $this->outputDriver->displayMessage($finalMessage);
        $this->currentScrollingPosition += 1;
        $this->updateLastScrollTickTime();
        DEBUG_logChar($this->currentMessage, $this->currentScrollingPosition);
        return $this->currentAppState;
    }

    private function getMessageForThisTick(): void
    {
        if ($this() === self::READY) {
            $this->setupNextMessage();
        }

        if ($this() === self::BUSY) {
            return;
        }
    }

    private function setupNextMessage(): void
    {
        $message = array_shift($this->displayQueue);

        if ($message === null) {
            throw NoMessageToDisplayException::create();
        }
        \E32CM\log('Setting up next message!');
        $this->currentMessage = $message['message'];
        $this->currentScrollingSpeed = $message['scrollMode'];
        $this->currentScrollingPosition = 0;
        $this->changeState(self::BUSY);
        $this->doTickTimeCheck = false;
    }

    public function displaySelectionContext(string $context, string $isBlinking): void
    {
    }

    public function clearScreen(): void
    {
    }

    public function updateLastScrollTickTime(): void
    {
        $this->lastScrollTickTime = microtime(true);
    }

    private function isValidScrollMode(string $scrollMode): bool
    {
        return in_array(
            $scrollMode,
            [
                self::NO_SCROLLING,
                self::VERY_SLOW_SCROLLING,
                self::SLOW_SCROLLING,
                self::NORMAL_SCROLLING,
                self::FAST_SCROLLING,
                self::VERY_FAST_SCROLLING,
                self::PRESENTATION_SCROLLING
            ]
        );
    }

    public function __invoke(): string
    {
        return $this->currentAppState;
    }

    private function changeState(string $newState): void
    {
        if ($this->currentAppState === $newState) {
            return;
        }

        \E32CM\log(PHP_EOL . 'Output state changed to ' . $newState);
        $this->currentAppState = $newState;
    }
}
