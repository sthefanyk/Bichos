<?php

namespace Core\Domain\Validation;
use Core\Domain\Exception\EntityValidationException;
use DateTime;

class DomainValidation
{
    public static function notNull(string $value, string $exceptionMessage = null)
    {
        if(empty($value)){
            throw new EntityValidationException($exceptionMessage ?? "Não pode ser vazio ou nulo!");
        }
    }

    public static function strMaxLength(string $value, int $max = 255, string $exceptionMessage = null)
    {
        if(strlen($value) > $max){
            throw new EntityValidationException($exceptionMessage ?? "Não pode ter mais que {$max} caracteres!");
        }
    }

    public static function strMinLength(string $value, int $min = 3, string $exceptionMessage = null)
    {
        if(strlen($value) < $min){
            throw new EntityValidationException($exceptionMessage ?? "Não pode ter menos que {$min} caracteres!");
        }
    }

    public static function futureDate(DateTime $date, string $exceptionMessage = null)
    {
        if($date > new DateTime()){
            throw new EntityValidationException($exceptionMessage ?? "Data inválida!");
        }
    }

    public static function strClean(string $name, string $exceptionMessage = null)
    {
        $regex  = "/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/";
        if (!preg_match($regex, $name)) {
            throw new EntityValidationException($exceptionMessage ?? "Nome inválido!");
        }
    }




}
