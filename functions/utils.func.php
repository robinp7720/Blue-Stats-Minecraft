<?php
function secondsToTime($seconds, $contract = true)
{
    if (!empty($seconds)) {
        $dtF = new DateTime("@0");
        $dtT = new DateTime("@$seconds");
        if ($contract) {
            if ($seconds >= 86400) {
                if ($seconds < 172800) {
                    if ($dtF->diff($dtT)->format('%h') == 1) {
                        return $dtF->diff($dtT)->format('%a day and %h hour');
                    } else {
                        return $dtF->diff($dtT)->format('%a day and %h hours');
                    }
                } else {
                    if ($dtF->diff($dtT)->format('%h') == 1) {
                        return $dtF->diff($dtT)->format('%a days and %h hour');
                    } else {
                        return $dtF->diff($dtT)->format('%a days and %h hours');
                    }
                }
            } elseif ($seconds >= 3600) {
                if ($seconds < 7200) {
                    if ($dtF->diff($dtT)->format('%i') == 1) {
                        return $dtF->diff($dtT)->format('%h hour and %i minute');
                    } else {
                        return $dtF->diff($dtT)->format('%h hour and %i minutes');
                    }
                } else {
                    if ($dtF->diff($dtT)->format('%i') == 1) {
                        return $dtF->diff($dtT)->format('%h hours and %i minute');
                    } else {
                        return $dtF->diff($dtT)->format('%h hours and %i minutes');
                    }
                }
            } elseif ($seconds >= 60) {
                if ($seconds < 120) {
                    return $dtF->diff($dtT)->format('%i minute');
                } else {
                    return $dtF->diff($dtT)->format('%i minutes');
                }

            } else {
                return $seconds . " seconds";
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