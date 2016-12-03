<?php

namespace App\Providers;

use Config;
use Countable;
use Exception;
use Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extendImplicit('required_if_province_quota', function ($attribute, $value, $parameters, $validator) {
            if (Config::get('uiconfig.mode') == 'province_quota') {
                if (is_null($value)) {
                    return false;
                } elseif (is_string($value) && trim($value) === '') {
                    return false;
                } elseif ((is_array($value) || $value instanceof Countable) && count($value) < 1) {
                    return false;
                }

                return true;
            } else {
                return true; // Not province quota, pass by default
            }
        });

        Validator::extend('within_date', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return false;
            }

            // Convert value in $parameters array to be easily accessible
            $parameters = array_reduce($parameters, function ($result, $item) {
                list($key, $value) = array_pad(explode('=', $item, 2), 2, NULL);

                $result[$key] = $value;

                return $result;
            });

            if (!isset($parameters['before']) && !isset($parameters['after'])) {
                throw new Exception('before or after parameter expected. None given');
            }

            $input = explode('/', $value);
            $input_year = $input[2];
            $input_month = $input[1];
            $input_day = $input[0];

            if (isset($parameters['before'])) {
                $before = explode('/', $parameters['before']);
                $before_year = $before[2];
                $before_month = $before[1];
                $before_day = $before[0];
                if ($before_year < $input_year) {
                    return false;
                } else {
                    if ($before_year == $input_year) {
                        if ($before_month < $input_month) {
                            return false;
                        } else {
                            if ($before_month == $input_month) {
                                if ($before_day < $input_day) {
                                    return false;
                                }
                            }
                        }
                    }
                }
            }

            if (isset($parameters['after'])) {
                $after = explode('/', $parameters['after']);
                $after_year = $after[2];
                $after_month = $after[1];
                $after_day = $after[0];
                if ($after_year > $input_year) {
                    return false;
                } else {
                    if ($after_year == $input_year) {
                        if ($after_month > $input_month) {
                            return false;
                        } else {
                            if ($after_month == $input_month) {
                                if ($after_day > $input_day) {
                                    return false;
                                }
                            }
                        }
                    }
                }
            }

            return true;
        });

        Validator::extend('citizen_id', function ($attribute, $value, $parameters, $validator) {
            if (strlen($citizen_id) == 13) { // First check the length

                $natid = str_split($citizen_id); // And split that into array

                /* Perform calculation. Multiply digits by their value */
                $c1 = $natid[0] * 13;
                $c2 = $natid[1] * 12;
                $c3 = $natid[2] * 11;
                $c4 = $natid[3] * 10;
                $c5 = $natid[4] * 9;
                $c6 = $natid[5] * 8;
                $c7 = $natid[6] * 7;
                $c8 = $natid[7] * 6;
                $c9 = $natid[8] * 5;
                $c10 = $natid[9] * 4;
                $c11 = $natid[10] * 3;
                $c12 = $natid[11] * 2;

                /* Get all the values, mod them by 11, and verify it to digit 13. */
                $val1 = $c1 + $c2 + $c3 + $c4 + $c5 + $c6 + $c7 + $c8 + $c9 + $c10 + $c11 + $c12;
                $val2 = $val1 % 11;
                $val3 = 11 - $val2;
                $val4 = substr($val3, -1);

                $checkdigit = $natid[12];

                if ($val4 == $checkdigit) { // Are we good?
                    // Yes!
                    return true;
                } else {
                    // NO!
                    return false;
                }

            } else {
                // Invalid length!
                return false;
            }
        });

        Validator::extend('subject_code', function ($attribute, $value, $parameters, $validator) {
            $code = str_split($value);

            if(!in_array($code[2], [1, 2])){
                return false;
            }

            return true;
        });

        Validator::extend('before_deadline', function($attribute, $value, $parameters, $validator){
            $input = explode('/', $value);
            $deadline = explode('/', Config::get('uiconfig.move_in_deadline'));

            if($input[2] < $deadline[2]){
                return true;
            }else if($input[2] == $deadline[2]){
                if($input[1] < $deadline[1]){
                    return true;
                }else if($input[1] == $deadline[1]){
                    if($input[0] < $deadline[0]){
                        return true;
                    }else if($input[0] == $deadline[0]){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
