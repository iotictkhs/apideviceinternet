<?php

class Time
{
    public function setTimeZone($timezone_identifier) {
        date_default_timezone_set($timezone_identifier);
    }

    public function getCurrentTimeZone() {
        return date_default_timezone_get();
    }

    public function getCurrentTimeStamp() {
        return date('m/d/Y h:i:s a', time());
    }

    public function getFormattedTimeStamp() {
        return $this->getCurrentTimeStamp()." (timezone: ".$this->getCurrentTimeZone().")";
    }
}