<?php
function secondsToTime($seconds, $contract = true)
{
    if (!empty($seconds)) {
        $dtF = new DateTime("@0");
        $dtT = new DateTime("@$seconds");
        if ($contract) {
            $mins = floor($seconds/60);
            $hours = floor($mins/60);
            $days = floor($hours/24);
            $weeks = floor($days/7);
            $months = floor($weeks/4.348125);
            $years = floor($months/12);

            $seconds -= $mins * 60;
            $mins -= $hours * 60;
            $hours -= $days * 24;
            $days -= $weeks * 7;
            $weeks -= $months * 4.348125;
            $months -= $years * 12;

            /* Text seconds */
            if (round($seconds)>0){
                if (round($seconds)>1){
                    $tseconds = $seconds . " seconds";
                }else{
                    $tseconds = $seconds . " second";
                }
            }else{
                $tseconds = "";
            }

            /* Text mins */
            if (round($mins)>0){
                if (round($mins)>1){
                    $tmins = $mins . " mins";
                }else{
                    $tmins = $mins . " min";
                }
            }else{
                $tmins = "";
            }

            /* Text hours */
            if (round($hours)>0){
                if (round($hours)>1){
                    $thours = $hours . " hours";
                }else{
                    $thours = $hours . " hours";
                }
            }else{
                $thours = "";
            }

            /* Text days */
            if (round($days)>0){
                if (round($days)>1){
                    $tdays = $days . " days";
                }else{
                    $tdays = $days . " day";
                }
            }else{
                $tdays = "";
            }

            /* Text weeks */
            if (round($weeks)>0){
                if (round($weeks)>1){
                    $tweeks = floor($weeks) . " weeks";
                }else{
                    $tweeks = ceil($weeks) . " week";
                }
            }else{
                $tweeks = "";
            }

            /* Text months */
            if (round($months)>0){
                if (round($months)>1){
                    $tmonths = $months . " months";
                }else{
                    $tmonths = $months . " month";
                }
            }else{
                $tmonths = "";
            }

            /* Text years */
            if (round($years)>0){
                if (round($years)>1){
                    $tyears = $years . " years";
                }else{
                    $tyears = $years . " year";
                }
            }else{
                $tyears = "";
            }

            if ($years > 0){
                return $tweeks.", ".$tmonths." and ".$tyears;
            }else if ($months > 0){
                if ($days > 0) {
                    return $tdays . ", " . $tweeks . " and " . $tmonths;
                }else{
                    return $tweeks . " and " . $tmonths;
                }
            }else if($weeks> 0){
                return $thours.", ".$tdays." and ".$tweeks;
            }else if($days > 0){
                return $thours." and ".$tdays;
            }else if ($hours > 0){
                return $tmins." and ".$thours;
            }else if($mins > 0){
                return $tseconds." and ".$tmins;
            }else{
                return $tseconds;
            }
        } else {
            if ($seconds >= 86400) {
                return $dtF->diff($dtT)->format('%ad:%hh:%mm:%ss');
            } elseif ($seconds >= 3600) {
                return $dtF->diff($dtT)->format('%hh:%im:%ss');
            } elseif ($seconds >= 60) {
                return $dtF->diff($dtT)->format('%im:%ss');
            } else {
                return $seconds . " seconds";
            }
        }
    }
    return false;
}