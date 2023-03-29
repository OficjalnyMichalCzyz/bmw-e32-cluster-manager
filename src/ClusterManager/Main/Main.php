<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main;

use E32CM\ClusterManager\Input\Input;
use E32CM\ClusterManager\Input\Mapper\Exception\UnknownButtonException;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\DisplayMessageCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\IdleCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\SkipMessageCommand;
use E32CM\ClusterManager\Main\ClusterApplications\ClusterApplication;
use E32CM\ClusterManager\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

class Main
{
    private Input $input;
    private Output $output;
    private ClusterApplication $clusterApplication;

    private string $lastOutputStatus = Output::READY;

    public function __construct(Input $input, Output $output, ClusterApplication $clusterApplication)
    {
        $this->input = $input;
        $this->output = $output;
        $this->clusterApplication = $clusterApplication;
    }

    public function run(): void
    {
        while (true) {
            usleep(100000);
            try {
                $inputCommand = $this->input->getInputIfAny();
            } catch (UnknownButtonException $exception) {
                $this->debugOutput->writeln('Unknown button!');
                $inputCommand = null;
            }

            if ($inputCommand === null) {
                $outputInstruction = $this->clusterApplication->tick($this->lastOutputStatus);
            } else {
                $outputInstruction = $this->clusterApplication->processCommand($inputCommand);
            }

            if ($outputInstruction instanceof DisplayMessageCommand) {
                try {
                    $this->output->displayMessage($outputInstruction->getMessage(), $outputInstruction->getScrollSpeed(), $outputInstruction->getDisplayMode());
                    $this->lastOutputStatus = $this->output->tick();
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
                continue;
            }

            if ($outputInstruction instanceof SkipMessageCommand) {
                try {
                    $this->output->skipCurrentMessage();
                    $this->lastOutputStatus = $this->output->tick();
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
                continue;
            }

            if ($outputInstruction instanceof IdleCommand) {
                try {
                    $this->lastOutputStatus = $this->output->tick();
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
                continue;
            }


            //try {
            //    $this->output->displayMessage("ABC", 0);
            //} catch (\Exception $exception) {
            //
            //}



        }
    }

    private ?OutputInterface $debugOutput;

    public function setDebugOutput(OutputInterface $debugOutput): void
    {
        $this->debugOutput = $debugOutput;
    }
}
