<?php

declare(strict_types=1);

namespace ERazdorova\OtusUserDataPackage\Enums;

class UserDataEnums
{
    public const GENDER_M = 'Мужской';
    public const GENDER_F = 'Женский';

    public const GENDER_RELATION = [
        self::GENDER_M => ['ич', 'лы'],
        self::GENDER_F => ['на', 'зы']
    ];

    public const AGE_INFANT     = 17;
    public const AGE_YOUNG      = 44;
    public const AGE_MIDDLE     = 59;
    public const AGE_ELDERLY    = 74;
    public const AGE_OLD        = 89;
    public const AGE_LONG_LIVER = 90;

    public const AGE_RELATION = [
        self::AGE_INFANT     => 'Несовершеннолетний возраст',
        self::AGE_YOUNG      => 'Молодой возраст',
        self::AGE_MIDDLE     => 'Средний возраст',
        self::AGE_ELDERLY    => 'Пожилой возраст',
        self::AGE_OLD        => 'Старческий возраст',
        self::AGE_LONG_LIVER => 'Долгожитель'
    ];
}
