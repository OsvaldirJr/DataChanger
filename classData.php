<?php 

Class DataChanger 
{
    
    /**
     * @param $data, operator $time
     * @return $newdata
     */
    private $data;
    private $operator;
    private $min;

    function __construct($data,$operator, $min){
        $this->data = $data;
        $this->operator=$operator;
        $this->min= $min;
    }
     function process(){
        $data=$this->data;
        $operator=$this->operator;
        $min=$this->min;
        // return $this->min;
         $sec=$min*60;
        //verifica se é o operador de adição
        if($operator=='+'){
            //transforma os segundos em H:M:S
            $datetime=$this->secToHMS($sec);
            // separa data e hora da string xx/xx/xxxx xx:xx
            $transiction=explode(' ', $data);
            // quebra horas e minutos em dois hh:mm em [0] =hh [1] = mm 
            $transictionhour=explode(':', $transiction[1]);
            // soma os minutos 
            $minutesall=intval($datetime['minute']+$transictionhour[1]);
            // soma as horas
            $minutes=$this->minutesToHour($minutesall);
            
            $hourall = intval($minutes['hour']+$datetime['hour']+$transictionhour[0]);
            // retorna o dia e a hora
            $days=$this->hourToDay($hourall);
            
            //
            $transictiondate=explode('/',$transiction[0]);
            $daysall=intval($days['days']+$transictiondate[0]);
            if($days['days']<=0){                
                $string = (string)($transiction[0].' '.$days['hours'].':'.$minutesall);
                return $string;
            }else{
                
                // return $days['days']
                $year=$transictiondate[2];
                $yearmonth=$transictiondate[1];
                do{
                    $month=$this->daysToMount($daysall, $yearmonth);
                    if(isset($month['leftover'])){
                        
                        $daysall=$month['leftover'];
                        $yearmonth=$month['month'];
                        $year=$year+1;
                    }else{
                        break;
                    }
                }while(1);
                
                if($month['month']<12){
                    // return $month;
                    $day=intval($month['days']);
                    $day = (strlen($day)<2 && $day<10)? '0'.$day : $day;
                    $month=intval($month['month']);
                    $month = (strlen($month)<2 && $month<10)? '0'.$month : $month;
                    $hour=$days['hours'];
                    $hour = (strlen($hour)<2 && $hour<10)? '0'.$hour : $hour;
                    $minutes=$minutes['minutes'];
                    $minutes= (strlen($minutes)<2 && $minutes<10)? '0'.$minutes : $minutes;
                    $date=(string)($day.'/'.$month.'/'.$year);
                    $string = (string)($date.' '.$hour.':'.$minutes);
                    return $string;
                }
                else{
                    return $month;
                }
                
            }
            // return $days; 
        }
        //verifica se é o operador de subtração
        else if($operator=='-'){
            dd('errado');
        }
        // para esse problema se não for adção ou subtração deve retornar um erro
        else{
            $error=['erro'=> true, 'code'=>'Operador invalido'];
            return $error;
        }
    }
    /**
     * @param $sec
     * @return $time
     */
    function secToHMS($sec) 
    { 
        // Calcula a quantidade de horas 
        $H = intval( $sec / 3600 ); 

        // Calcula a quantidade de minutos 
        $M = $sec % 3600; 
        $M = intval( $M / 60 ); 

        // Calcula a quantidade de segundos 
        $S = ( $sec - ( ( $H * 3600 ) + ( $M * 60 ) ) ); 

        // Insere zeros à esquerda se necessário 
        strlen( $H ) < 2 ? 
                $H = '0'.$H : 
                $H = $H; 
        strlen( $M ) < 2 ? 
                $M = '0'.$M : 
                $M = $M; 
        strlen( $S ) < 2 ? 
                $S = '0'.$S: 
                $S = $S; 
        // Retorna a string 
        $hour=['hour'=>$H, 'minute'=>$M, 'secundes'=>$S]; 

        return $hour;
    } 
     function minutesToHour($minutes){
        $hour = intval( $minutes / 60 ); 
        $hourmin=intval($minutes%60);

        return ['hour'=>$hour,'minutes'=>$hourmin];
    }
     function daysToMount($days, $month){
        switch($month){
            case 1:
                $monthf = intval($days/31);
                $monthday=intval($days%31);
                // return $days;
               if($monthf>0){
                    $quantity=intval($days/59);
                    if($quantity>0){
                        $quantity=intval($days/90);
                        if($quantity>0){
                            $quantity=intval($days/120);
                            if($quantity>0){
                                $quantity=intval($days/150);
                                if($quantity>0){
                                    $quantity=intval($days/181);
                                    if($quantity>0){
                                        $quantity=intval($days/211);
                                        if($quantity>0){
                                            $quantity=intval($days/242);
                                            if($quantity>0){
                                                $quantity=intval($days/273);
                                                if($quantity>0){
                                                    $quantity=intval($days/303);
                                                    if($quantity>0){
                                                        $quantity=intval($days/333);
                                                        if($quantity>0){
                                                            $quantity=intval($days/360);
                                                            if($quantity>0){
                                                                $quantity=intval($days/365);
                                                                if($quantity>0){
                                                                    $leftover=$days-365;
                                                                    return ['leftover'=>$leftover,'year'=>1, 'month'=>1, 'days'=>$monthday];
                                                                    
                                                                }else{
                                                                    return ['month'=>12, 'days'=>$monthday];
                                                                }
                                                            }else{
                                                                return ['month'=>12, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['month'=>11, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['month'=>10, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['month'=>9, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['month'=>8, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['month'=>7, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['month'=>6, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['month'=>5, 'days'=>$monthday];
                                }
                            }else{
                                return ['month'=>4, 'days'=>$monthday];
                            }    
                        }else{
                            return ['month'=>3, 'days'=>$monthday];
                        }
                    }else{
                        return ['month'=>2, 'days'=>$monthday];
                    }
               }
               else{
                return ['month'=>1, 'days'=>$monthday];
               }
            case 2:
            $monthf = intval($days/28);
            $monthday=intval($days%28);
            
           if($monthf>0){
                $quantity=intval($days/59);
                if($quantity>0){
                    $quantity=intval($days/89);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/151);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/212);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                        if($quantity>0){
                                                            $quantity=intval($days/360);
                                                            if($quantity>0){
                                                                $quantity=intval($days/365);
                                                                if($quantity>0){
                                                                    $leftover=$days-365;
                                                                    return ['leftover'=>$leftover, 'year'=>1,'month'=>2, 'days'=>$monthday];
                                                                    
                                                                }else{
                                                                    return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                                                }
                                                            }else{
                                                                return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                                            }
                                                       
                                                    }else{
                                                        return ['year'=>0,'month'=>12, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>0,'month'=>11, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>0,'month'=>10, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>0,'month'=>9, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>0,'month'=>8, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>0,'month'=>7, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>6, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>5, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>4, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>3, 'days'=>$monthday];
                }
           }
           else{
            return ['year'=>0,'month'=>2, 'days'=>$monthday];
           }
            case 3:
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            
           if($monthf>0){
                $quantity=intval($days/61);
                if($quantity>0){
                    $quantity=intval($days/92);
                    if($quantity>0){
                        $quantity=intval($days/122);
                        if($quantity>0){
                            $quantity=intval($days/153);
                            if($quantity>0){
                                $quantity=intval($days/184);
                                if($quantity>0){
                                    $quantity=intval($days/214);
                                    if($quantity>0){
                                        $quantity=intval($days/245);
                                        if($quantity>0){
                                            $quantity=intval($days/275);
                                            if($quantity>0){
                                                $quantity=intval($days/305);
                                                if($quantity>0){
                                                    $quantity=intval($days/335);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>3, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                                        }
                                                       
                                                    }else{
                                                        return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>0,'month'=>12, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>0,'month'=>11, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>0,'month'=>10, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>0,'month'=>9, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>0,'month'=>8, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>7, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>6, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>5, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>4, 'days'=>$monthday];
                }
           }
           else{
            return ['year'=>0,'month'=>3, 'days'=>$monthday];
           }
            case 4:
            $monthf = intval($days/30);
            $monthday=intval($days%30);
            
           if($monthf>0){
                $quantity=intval($days/61);
                if($quantity>0){
                    $quantity=intval($days/92);
                    if($quantity>0){
                        $quantity=intval($days/122);
                        if($quantity>0){
                            $quantity=intval($days/153);
                            if($quantity>0){
                                $quantity=intval($days/184);
                                if($quantity>0){
                                    $quantity=intval($days/214);
                                    if($quantity>0){
                                        $quantity=intval($days/245);
                                        if($quantity>0){
                                            $quantity=intval($days/275);
                                            if($quantity>0){
                                                $quantity=intval($days/305);
                                                if($quantity>0){
                                                    $quantity=intval($days/335);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>4, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                                        }
                                                       
                                                    }else{
                                                        return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>0,'month'=>12, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>0,'month'=>11, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>0,'month'=>10, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>0,'month'=>9, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>8, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>7, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>6, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>5, 'days'=>$monthday];
                }
           }
           else{
            return ['year'=>0,'month'=>4, 'days'=>$monthday];
           }
            case 5:
                  
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            
           if($monthf>0){
                $quantity=intval($days/61);
                if($quantity>0){
                    $quantity=intval($days/92);
                    if($quantity>0){
                        $quantity=intval($days/122);
                        if($quantity>0){
                            $quantity=intval($days/153);
                            if($quantity>0){
                                $quantity=intval($days/184);
                                if($quantity>0){
                                    $quantity=intval($days/214);
                                    if($quantity>0){
                                        $quantity=intval($days/245);
                                        if($quantity>0){
                                            $quantity=intval($days/275);
                                            if($quantity>0){
                                                $quantity=intval($days/305);
                                                if($quantity>0){
                                                    $quantity=intval($days/335);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>5, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                                        }
                                                       
                                                    }else{
                                                        return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>0,'month'=>12, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>0,'month'=>11, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>0,'month'=>10, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>9, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>8, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>7, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>6, 'days'=>$monthday];
                }
           }
           else{
            return ['year'=>0,'month'=>5, 'days'=>$monthday];
           }
            case 6:
                  
            $monthf = intval($days/30);
            $monthday=intval($days%30);
            
           if($monthf>0){
                $quantity=intval($days/61);
                if($quantity>0){
                    $quantity=intval($days/92);
                    if($quantity>0){
                        $quantity=intval($days/122);
                        if($quantity>0){
                            $quantity=intval($days/153);
                            if($quantity>0){
                                $quantity=intval($days/184);
                                if($quantity>0){
                                    $quantity=intval($days/214);
                                    if($quantity>0){
                                        $quantity=intval($days/245);
                                        if($quantity>0){
                                            $quantity=intval($days/275);
                                            if($quantity>0){
                                                $quantity=intval($days/305);
                                                if($quantity>0){
                                                    $quantity=intval($days/335);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>6, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                                        }
                                                       
                                                    }else{
                                                        return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>0,'month'=>12, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>0,'month'=>11, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>10, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>9, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>8, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>7, 'days'=>$monthday];
                }
           }
           else{
            return ['year'=>0,'month'=>6, 'days'=>$monthday];
           }
            case 7:
                  
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            if($monthf>0){
                if($quantity>0){
                    $quantity=intval($days/90);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/150);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/211);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>7, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>7, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>0,'month'=>12, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>11, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>10, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>9, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>8, 'days'=>$monthday];
                }
            }else{
                return ['year'=>0,'month'=>7, 'days'=>$monthday];
            }
            case 8:
                  
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            if($monthf>0){
                if($quantity>0){
                    $quantity=intval($days/90);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/150);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/211);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>8, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>8, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>7, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>1,'month'=>1, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>0,'month'=>12, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>11, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>10, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>9, 'days'=>$monthday];
                }
            }else{
                return ['year'=>0,'month'=>8, 'days'=>$monthday];
            }
            case 9:
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            if($monthf>0){
                if($quantity>0){
                    $quantity=intval($days/90);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/150);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/211);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>9, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>9, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>8, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['year'=>1,'month'=>7, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>1,'month'=>2, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>1,'month'=>1, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>0,'month'=>12, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>11, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>10, 'days'=>$monthday];
                }
            }else{
                return ['year'=>0,'month'=>9, 'days'=>$monthday];
            }
            case 10:
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            if($monthf>0){
                if($quantity>0){
                    $quantity=intval($days/90);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/150);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/211);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>10, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>10, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>9, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['year'=>1,'month'=>8, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>7, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>1,'month'=>3, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>1,'month'=>2, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>1,'month'=>1, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>0,'month'=>12, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>11, 'days'=>$monthday];
                }
            }else{
                return ['year'=>0,'month'=>10, 'days'=>$monthday];
            }
            case 11:
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            if($monthf>0){
                if($quantity>0){
                    $quantity=intval($days/90);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/150);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/211);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>11, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>11, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>10, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['year'=>1,'month'=>9, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>8, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>7, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>1,'month'=>4, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>1,'month'=>3, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>1,'month'=>2, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>1,'month'=>1, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>0,'month'=>12, 'days'=>$monthday];
                }
            }else{
                return ['year'=>0,'month'=>11, 'days'=>$monthday];
            }
            case 12:
            $monthf = intval($days/31);
            $monthday=intval($days%31);
            if($monthf>0){
                if($quantity>0){
                    $quantity=intval($days/90);
                    if($quantity>0){
                        $quantity=intval($days/120);
                        if($quantity>0){
                            $quantity=intval($days/150);
                            if($quantity>0){
                                $quantity=intval($days/181);
                                if($quantity>0){
                                    $quantity=intval($days/211);
                                    if($quantity>0){
                                        $quantity=intval($days/242);
                                        if($quantity>0){
                                            $quantity=intval($days/273);
                                            if($quantity>0){
                                                $quantity=intval($days/303);
                                                if($quantity>0){
                                                    $quantity=intval($days/333);
                                                    if($quantity>0){
                                                        $quantity=intval($days/360);
                                                        if($quantity>0){
                                                            $quantity=intval($days/365);
                                                            if($quantity>0){
                                                                $leftover=$days-365;
                                                                return ['leftover'=>$leftover, 'year'=>1,'month'=>12, 'days'=>$monthday];
                                                                
                                                            }else{
                                                                return ['year'=>1,'month'=>12, 'days'=>$monthday];
                                                            }
                                                        }else{
                                                            return ['year'=>1,'month'=>11, 'days'=>$monthday];
                                                        }
                                                    }else{
                                                        return ['year'=>1,'month'=>10, 'days'=>$monthday];
                                                    }
                                                }else{
                                                    return ['year'=>1,'month'=>9, 'days'=>$monthday];
                                                }
                                            }else{
                                                return ['year'=>1,'month'=>8, 'days'=>$monthday];
                                            }
                                        }else{
                                            return ['year'=>1,'month'=>7, 'days'=>$monthday];
                                        }
                                    }else{
                                        return ['year'=>1,'month'=>6, 'days'=>$monthday];
                                    }
                                }else{
                                    return ['year'=>1,'month'=>5, 'days'=>$monthday];
                                }
                            }else{
                                return ['year'=>1,'month'=>4, 'days'=>$monthday];
                            }
                        }else{
                            return ['year'=>1,'month'=>3, 'days'=>$monthday];
                        }    
                    }else{
                        return ['year'=>1,'month'=>2, 'days'=>$monthday];
                    }
                }else{
                    return ['year'=>1,'month'=>1, 'days'=>$monthday];
                }
            }else{
                return ['year'=>0,'month'=>12, 'days'=>$monthday];
            }
        }
    }
     function hourToDay($hour){
       $days=intval($hour/24);
       $hours=intval($hour%24);
       $response=['days'=>$days, 'hours'=>$hours];
       return $response;
    }
}