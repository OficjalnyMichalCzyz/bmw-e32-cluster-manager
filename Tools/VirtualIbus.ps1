cls;
Write-Host "`n`n`n`n`n`n`n`n"

$steeringWheel = '             Last emulated button

############################################################################################################
############################################################################################################

              ##                    ##
            ####                    ####            Press buttons written under pictograms to emulate those
          ##    ######        ######    ##          steering wheel buttons.
       ##                                 ##
          ##    ######        ######    ##          WARNING: holding down the button does not work!
            ####                    ####
              ##                    ##

             Left                Right

                                    ##
                                    ##
                                    ##
         ############          ############
                                    ##
                                    ##
                                    ##

             Down                  Up

          ######      #######     #####
          #     #   #    #       ###
          ######   #     #       ##
          #   #   #      #       ###
          #    #         #        ####

            Z                      X

############################################################################################################
############################################################################################################
';

$left = '
                      ##
                    ####
                  ##    ######
                ##
                  ##    ######
                    ####
                      ##
';
$right = '
                      ##
                      ####
                ######    ##
                            ##
                ######    ##
                      ####
                      ##
';
$up = '
                     ##
                     ##
                     ##
                ############
                     ##
                     ##
                     ##
';
$down = '



                ############



';
$rt = '

                ######      #######
                #     #   #    #
                ######   #     #
                #   #   #      #
                #    #         #

';
$tp = '

                       #####
                      ###
                      ##
                      ###
                       ####

';

function EmulateButton {
    param ($buttonName)
    Set-Content -Path VirtualIbus.txt -Value $buttonName
    $global:lastButton = $buttonName;
}

$global:lastButton = '';

while ($true) {
    Write-Host($steeringWheel);
    $keyPress = [System.Console]::ReadKey().key;
    if ($keyPress.lenght -eq 2) {
        $keyPress = $keyPress.substring(0.1);
    }
    cls;
    if($keyPress -eq 'LeftArrow') {
        Write-Host($left);
        EmulateButton('LEFT_BUTTON');
        continue;
    }

    if($keyPress -eq 'RightArrow') {
        Write-Host($right);
        EmulateButton('RIGHT_BUTTON');
        continue;
    }

    if($keyPress -eq 'DownArrow') {
        Write-Host($down);
        EmulateButton('PLUS_BUTTON');
        continue;
    }

    if($keyPress -eq 'UpArrow') {
        Write-Host($up);
        EmulateButton('MINUS_BUTTON');
        continue;
    }

    if($keyPress -eq 'Z') {
        Write-Host($rt);
        EmulateButton('RT_BUTTON');
        continue;
    }

    if($keyPress -eq 'X') {
        Write-Host($tp);
        EmulateButton('TELEPHONE_BUTTON');
        continue;
    }

    Write-Host "`n`n`n`n`n`n`n`n"
}















#
#$left = '
#              ##
#            ####
#          ##    ######
#        ##
#          ##    ######
#            ####
#              ##
#';
#$right = '
#              ##
#              ####
#        ######    ##
#                    ##
#        ######    ##
#              ####
#              ##
#';
#$up = '
#             ##
#             ##
#             ##
#        ############
#             ##
#             ##
#             ##
#';
#$down = '
#
#
#
#        ############
#
#
#
#';
#$rt = '
#
#        ######      #######
#        #     #   #    #
#        ######   #     #
#        #   #   #      #
#        #    #         #
#
#';
#$tp = '
#
#               #####
#              ###
#              ##
#              ###
#               ####
#
#';