<?php
    class Log {
        private string $message;

        public static function log(
                string $message = "",
                Exception $e = null // Le polymorphisme
            ) {
                
            $now = new Datetime();
            $msg = $now->format("d/m/Y") . "\n";

            if ($message != "") {
                $msg .= $message . "\n";
            }

            if ($e != null) {
                $msg .= "Fichier : " . $e->getFile() . "\n";
                $msg .= "Ligne : " . $e->getLine() . "\n";
                $msg .= "Code : " . $e->getCode() . "\n";
                $msg .= $e->getMessage() . "\n";
            }

            error_log($msg, 3, "err.log");
        }
    }