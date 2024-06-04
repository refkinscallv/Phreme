<?php

    namespace Phreme\Systems;

    defined("PHREME") OR exit("Forbidden Access");

    class Common {
        
        /**
         * base_url()
         *
         * @param  string $path
         * @return string
         */
        public function base_url(string $path = null): string {
            return rtrim($_SERVER["BASE_URL"], "/") . "/" . ($path ? $path : "");
        }
        
        /**
         * http_response()
         *
         * @param  int $code
         * @return object
         */
        public function http_response(int $code = 0): object {
            $status_message = "Unknwon Error";

            switch ($code) {
                case 100:
                    $status_message = "Continue";
                    break;
                case 101:
                    $status_message = "Switching Protocols";
                    break;
                case 102:
                    $status_message = "Processing";
                    break;
                case 200:
                    $status_message = "OK";
                    break;
                case 201:
                    $status_message = "Created";
                    break;
                case 202:
                    $status_message = "Accepted";
                    break;
                case 203:
                    $status_message = "Non-Authoritative Information";
                    break;
                case 204:
                    $status_message = "No Content";
                    break;
                case 205:
                    $status_message = "Reset Content";
                    break;
                case 206:
                    $status_message = "Partial Content";
                    break;
                case 207:
                    $status_message = "Multi-Status";
                    break;
                case 300:
                    $status_message = "Multiple Choices";
                    break;
                case 301:
                    $status_message = "Moved Permanently";
                    break;
                case 302:
                    $status_message = "Found";
                    break;
                case 303:
                    $status_message = "See Other";
                    break;
                case 304:
                    $status_message = "Not Modified";
                    break;
                case 305:
                    $status_message = "Use Proxy";
                    break;
                case 306:
                    $status_message = "(Unused)";
                    break;
                case 307:
                    $status_message = "Temporary Redirect";
                    break;
                case 308:
                    $status_message = "Permanent Redirect";
                    break;
                case 400:
                    $status_message = "Bad Request";
                    break;
                case 401:
                    $status_message = "Unauthorized";
                    break;
                case 402:
                    $status_message = "Payment Required";
                    break;
                case 403:
                    $status_message = "Forbidden";
                    break;
                case 404:
                    $status_message = "Not Found";
                    break;
                case 405:
                    $status_message = "Method Not Allowed";
                    break;
                case 406:
                    $status_message = "Not Acceptable";
                    break;
                case 407:
                    $status_message = "Proxy Authentication Required";
                    break;
                case 408:
                    $status_message = "Request Timeout";
                    break;
                case 409:
                    $status_message = "Conflict";
                    break;
                case 410:
                    $status_message = "Gone";
                    break;
                case 411:
                    $status_message = "Length Required";
                    break;
                case 412:
                    $status_message = "Precondition Failed";
                    break;
                case 413:
                    $status_message = "Request Entity Too Large";
                    break;
                case 414:
                    $status_message = "Request-URI Too Long";
                    break;
                case 415:
                    $status_message = "Unsupported Media Type";
                    break;
                case 416:
                    $status_message = "Requested Range Not Satisfiable";
                    break;
                case 417:
                    $status_message = "Expectation Failed";
                    break;
                case 418:
                    $status_message = "I'm a teapot";
                    break;
                case 419:
                    $status_message = "Authentication Timeout";
                    break;
                case 420:
                    $status_message = "Enhance Your Calm";
                    break;
                case 422:
                    $status_message = "Unprocessable Entity";
                    break;
                case 423:
                    $status_message = "Locked";
                    break;
                case 424:
                    $status_message = "Failed Dependency";
                    break;
                case 425:
                    $status_message = "Unordered Collection";
                    break;
                case 426:
                    $status_message = "Upgrade Required";
                    break;
                case 428:
                    $status_message = "Precondition Required";
                    break;
                case 429:
                    $status_message = "Too Many Requests";
                    break;
                case 431:
                    $status_message = "Request Header Fields Too Large";
                    break;
                case 444:
                    $status_message = "No Response";
                    break;
                case 449:
                    $status_message = "Retry With";
                    break;
                case 450:
                    $status_message = "Blocked by Windows Parental Controls";
                    break;
                case 451:
                    $status_message = "Unavailable For Legal Reasons";
                    break;
                case 494:
                    $status_message = "Request Header Too Large";
                    break;
                case 495:
                    $status_message = "Cert Error";
                    break;
                case 496:
                    $status_message = "No Cert";
                    break;
                case 497:
                    $status_message = "HTTP to HTTPS";
                    break;
                case 499:
                    $status_message = "Client Closed Request";
                    break;
                case 500:
                    $status_message = "Internal Server Error";
                    break;
                case 501:
                    $status_message = "Not Implemented";
                    break;
                case 502:
                    $status_message = "Bad Gateway";
                    break;
                case 503:
                    $status_message = "Service Unavailable";
                    break;
                case 504:
                    $status_message = "Gateway Timeout";
                    break;
                case 505:
                    $status_message = "HTTP Version Not Supported";
                    break;
                case 506:
                    $status_message = "Variant Also Negotiates";
                    break;
                case 507:
                    $status_message = "Insufficient Storage";
                    break;
                case 508:
                    $status_message = "Loop Detected";
                    break;
                case 509:
                    $status_message = "Bandwidth Limit Exceeded";
                    break;
                case 510:
                    $status_message = "Not Extended";
                    break;
                case 511:
                    $status_message = "Network Authentication Required";
                    break;
                case 598:
                    $status_message = "Network read timeout error";
                    break;
                case 599:
                    $status_message = "Network connect timeout error";
                    break;
                default:
                    $status_message = "Unknown Status";
                    break;
            }

            return (object) [
                "code" => $code,
                "message" => $status_message
            ];
        }
        
        /**
         * number_short()
         *
         * @param  int $number
         * @param  int $precision
         * @return mixed
         */
        public function number_short(int $number, int $precision = 1): mixed {
            if ($number < 900) {
                $formatted_number = number_format($number, $precision);
                $suffix = '';
            } else 
            if ($number < 900000) {
                $formatted_number = number_format($number / 1000, $precision);
                $suffix = 'K';
            } else 
            if ($number < 900000000) {
                $formatted_number = number_format($number / 1000000, $precision);
                $suffix = 'M';
            } else 
            if ($number < 900000000000) {
                $formatted_number = number_format($number / 1000000000, $precision);
                $suffix = 'B';
            } else {
                $formatted_number = number_format($number / 1000000000000, $precision);
                $suffix = 'T';
            }

            if($precision > 0){
                $dotzero = '.'. str_repeat( '0', $precision );
                $formatted_number = str_replace( $dotzero, '', $formatted_number );
            }

            return $formatted_number . $suffix;
        }
        
        /**
         * size_short()
         *
         * @param  int $size
         * @return mixed
         */
        public function size_short(int $size): mixed {
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;

            return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        }
        
        /**
         * unique_file()
         *
         * @param  string $path
         * @param  string $filename
         * @return string
         */
        public function unique_file(string $path, string $filename): string {
            $file_parts = explode(".", $filename);
            $ext = array_pop($file_parts);
            $name = implode(".", $file_parts);

            $i = 1;
            
            while (file_exists($path . $filename)) {
                $filename = $name . '-' . ($i++) . '.' . $ext;
            }

            return $filename;
        }
        
        /**
         * output()
         *
         * @param  mixed $data
         * @return mixed
         */
        public function output(mixed $data = null): mixed {
            echo $data;
        }
        
        /**
         * output_json()
         *
         * @param  array $data
         * @return mixed
         */
        public function output_json(array $data): mixed {
            echo json_encode($data, JSON_UNESCAPED_SLASHES);
        }
        
        /**
         * clean_url()
         *
         * @param  string $string
         * @return string
         */
        public function clean_url(string $string): string {
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
            $string = str_replace(' ', '-', $string);
            $string = strtolower($string);

            return $string;
        }
        
        /**
         * form_validate()
         *
         * @param  array $data
         * @return object
         */
        public function form_validate(array $data): object {
            $fvss   = Dependencies::formValidate();

            return $fvss->validate($data);
        }
        
        /**
         * generate_random_string()
         *
         * @param  int  $length
         * @return string
         */
        public function generate_random_string(int $length): string {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

    }