<?php

Class Data {

    private $dia;
    private $diaSemana;
    private $mes;
    private $ano;

    /*
     * construtor
     */

    public function __construct($day = '') {
        if ($day == '') {
            $this->diaSemana = date('w');
            $this->dia = date('d');
            $this->mes = date('n');
            $this->ano = date('Y');
        } else {
            $p = explode('/', $day);
            $this->dia = $p[0];
            $this->mes = $p[1];
            $this->ano = $p[2];

            $this->diaSemana = date("w", mktime(0, 0, 0, $this->mes, $this->dia, $this->ano));
        }
    }

    public function getDataActual() {
        $mes = self::Mes();
        $diaSemana = self::Dia();

        $data = $diaSemana . ' ' . $this->dia . ' de ' . $mes . ' de ' . $this->ano;
        return $data;
    }

    public function getDataMySQL() {
        return date('Y-m-d', mktime(0, 0, 0, $this->mes, $this->dia, $this->ano));
    }

    public function Mes() {
        $Mes = array(
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        );

        return $Mes[$this->mes];
    }

    public function Dia() {
        $dia = array(
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado'
        );

        return $dia[$this->diaSemana];
    }

    public static function converteAMD2DMA($datetime) {
        $arr = explode('-', $datetime);
        $nova_data = substr($arr[2], 0, -9) . '-' . $arr[1] . '-' . $arr[0] . "" . substr($arr[2], 2);
        return $nova_data;
    }

    public static function converteAMD2ptDMA($data, $separador = null) {
        $arr = explode('-', $data);
        $divisor = $separador == null ? "-" : $separador;
        $nova_data = $arr[2] . $divisor . $arr[1] . $divisor . $arr[0];
        return $nova_data;
    }

    public static function daDiferencaTempoParametro($datetime_inicio, $datetime_fim, $parametroTempo = "ANOS") {

        $datetime_inicio = new DateTime($datetime_inicio);
        $datetime_fim = new DateTime($datetime_fim);

        $retorno = "";
        $intervalo = $datetime_fim->diff($datetime_inicio);
        switch ($parametroTempo) {
           case Geral::CONS_PARAMETRO_TEMPO_ANOS: $retorno = (int) $intervalo->format('%y');
                break;
            case Geral::CONS_PARAMETRO_TEMPO_MESES: $retorno = (int) $intervalo->format('%m');
                break;
            case Geral::CONS_PARAMETRO_TEMPO_DIAS: $retorno = (int) $intervalo->format('%a');
                break;
            case Geral::CONS_PARAMETRO_TEMPO_HORAS: $retorno = (int) $intervalo->format('%h');
                break;
            case Geral::CONS_PARAMETRO_TEMPO_MINUTOS: $retorno = (int) $intervalo->format('%i');
                break;
            case Geral::CONS_PARAMETRO_TEMPO_SEGUNDOS: $retorno = (int) $intervalo->format('%s');
                break;
            default: break;
        }
        return $retorno;
    }

    public static function daDuracaoEmHorasMinutos($datetime_inicio, $datetime_fim) {
        $datetime_inicio = new DateTime($datetime_inicio);
        $datetime_fim = new DateTime($datetime_fim);
        $intervalo = $datetime_fim->diff($datetime_inicio);

        $horas = (int) $intervalo->format('%h');
        $minutos = (int) $intervalo->format('%i');
        if ($horas <= 0) {
            return $minutos . " minutos";
        }
        if ($minutos <= 0) {
            return $horas . " horas";
        } else {
            return $horas . " horas e " . $minutos . " minutos";
        }
    }

    public static function daDiferencaSegundosDateTimes($datetime_fim, $datetime_inicio) {

        $date = new DateTime($datetime_inicio);
        $date2 = new DateTime($datetime_fim);

        $diferenca = $date2->getTimestamp() - $date->getTimestamp();
        return $diferenca;
    }

    public static function calculaDuracao($data_inicio, $data_fim) {


// Declare and define two dates 
        $date1 = strtotime($data_inicio);
        $date2 = strtotime($data_fim);

// Formulate the Difference between two dates 
        $diff = abs($date2 - $date1);


// To get the year divide the resultant date into 
// total seconds in a year (365*60*60*24) 
        $years = floor($diff / (365 * 60 * 60 * 24));


// To get the month, subtract it with years and 
// divide the resultant date into 
// total seconds in a month (30*60*60*24) 
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));


// To get the day, subtract it with years and 
// months and divide the resultant date into 
// total seconds in a days (60*60*24) 
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


// To get the hour, subtract it with years, 
// months & seconds and divide the resultant 
// date into total seconds in a hours (60*60) 
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));


// To get the minutes, subtract it with years, 
// months, seconds and hours and divide the 
// resultant date into total seconds i.e. 60 
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);


// To get the minutes, subtract it with years, 
// months, seconds, hours and minutes 
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

// Print the result 
        // printf("%d years, %d months, %d days, %d hours, "
        //     . "%d minutes, %d seconds", $years, $months, $days, $hours, $minutes, $seconds);
        $txtResultado = "";

        if ($days == 0) {
            $txtResultado .= "";

            if ($hours == 0) {
                $txtResultado .= "";
                if ($minutes <= 0) {
                    $txtResultado .= "";
                }

                if ($minutes == 1) {
                    $txtResultado .= " ";
                    $txtResultado .= " 1 minuto ";
                }
                if ($minutes > 1) {
                    $txtResultado .= "  ";
                    $txtResultado .= $minutes . "  minutos ";
                }
            }
         else {
            //$txtResultado .= " e ";
            if ($hours == 1) {
                $txtResultado .= " 1 hora ";

                if ($minutes == 0) {
                    $txtResultado .= "";
                } else {
                    $txtResultado .= " e ";
                    if ($minutes == 1) {
                        $txtResultado .= " 1 minuto ";
                    }
                    if ($minutes > 1) {
                        $txtResultado .= $minutes . " minutos ";
                    }
                }
            }
            if ($hours > 1) {
                $txtResultado .= $hours . " horas ";

                if ($minutes == 0) {
                    $txtResultado .= "";
                } else {
                    $txtResultado .= " e ";
                    if ($minutes == 1) {
                        $txtResultado .= " 1 minuto ";
                    }
                    if ($minutes > 1) {
                        $txtResultado .= $minutes . " minutos ";
                    }
                }
            }
        }
        } else {
            if ($days == 1) {
                $txtResultado .= " 1 dia ";


                if ($hours == 0) {
                    $txtResultado .= "";
                    if ($minutes == 0) {
                        $txtResultado .= "";
                    } else {
                        $txtResultado .= " e ";
                        if ($minutes == 1) {
                            $txtResultado .= " 1 minuto ";
                        }
                        if ($minutes > 1) {
                            $txtResultado .= $minutes . "  minutos ";
                        }
                    }
                } else {
                    $txtResultado .= " e ";
                    if ($hours == 1) {
                        $txtResultado .= " 1 hora ";


                        if ($minutes == 0) {
                            $txtResultado .= "";
                        } else {
                            $txtResultado .= " e ";
                            if ($minutes == 1) {
                                $txtResultado .= " 1 minuto ";
                            }
                            if ($minutes > 1) {
                                $txtResultado .= $minutes . " minutos ";
                            }
                        }
                    }
                    if ($hours > 1) {
                        $txtResultado .= $hours . " horas ";

                        if ($minutes == 0) {
                            $txtResultado .= "";
                        } else {
                            $txtResultado .= " e ";
                            if ($minutes == 1) {
                                $txtResultado .= " 1 minuto ";
                            }
                            if ($minutes > 1) {
                                $txtResultado .= $minutes . " minutos ";
                            }
                        }
                    }
                }
            }
            if ($days > 1) {
                $txtResultado .= $days . " dias ";

                if ($hours == 0) {
                    $txtResultado .= "";
                    if ($minutes == 0) {
                        $txtResultado .= "";
                    } else {
                        $txtResultado .= " e ";
                        if ($minutes == 1) {
                            $txtResultado .= " 1 minuto ";
                        }
                        if ($minutes > 1) {
                            $txtResultado .= $minutes . "  minutos ";
                        }
                    }
                } else {
                    $txtResultado .= " e ";
                    if ($hours == 1) {
                        $txtResultado .= " 1 hora ";


                        if ($minutes == 0) {
                            $txtResultado .= "";
                        } else {
                            $txtResultado .= " e ";
                            if ($minutes == 1) {
                                $txtResultado .= " 1 minuto ";
                            }
                            if ($minutes > 1) {
                                $txtResultado .= $minutes . " minutos ";
                            }
                        }
                    }
                    if ($hours > 1) {
                        $txtResultado .= $hours . " horas ";

                        if ($minutes == 0) {
                            $txtResultado .= "";
                        } else {
                            $txtResultado .= " e ";
                            if ($minutes == 1) {
                                $txtResultado .= " 1 minuto ";
                            }
                            if ($minutes > 1) {
                                $txtResultado .= $minutes . " minutos ";
                            }
                        }
                    }
                }
            }
        }

        return $txtResultado;
    }

}
