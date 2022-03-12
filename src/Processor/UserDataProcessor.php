<?php

declare(strict_types=1);

namespace ERazdorova\OtusUserDataPackage\Processor;

use ERazdorova\OtusUserDataPackage\Enums\UserDataEnums;
use Carbon\Carbon;
use Exception;

class UserDataProcessor
{
    /**
     * @var string|null Отчество
     */
    protected ?string $patronymic = null;

    /**
     * @var Carbon|null Дата рождения
     */
    protected ?Carbon $birthDate = null;

    /**
     * @var string|null Пол
     */
    protected ?string $gender = null;

    /**
     * @var int|null Возраст
     */
    protected ?int $age = null;

    /**
     * @var string|null Возрастная категория
     */
    protected ?string $ageGrade = null;

    /**
     * @param string|null $patronymic
     * @param string|null $birthDate
     */
    public function __construct(?string $patronymic, ?string $birthDate)
    {
        $this->setPatronymic($patronymic)->setBirthDate($birthDate);
        if ($this->patronymic) {
            $this->setGender();
        }

        if ($this->birthDate) {
            $this->setAge()->setAgeGrade();
        }
    }

    /**
     * @param string|null $patronymic
     * @return self
     */
    public function setPatronymic(?string $patronymic): self
    {
        try {
            $this->patronymic = self::checkPatronymic($patronymic);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * @param string|null $patronymic
     * @return string|null
     * @throws Exception
     */
    private static function checkPatronymic(?string $patronymic): ?string
    {
        if (!empty($patronymic)) {
            if (!preg_match('/^[а-яё\-` ]+$/imu', $patronymic)) {
                throw new Exception('Отчество содержит недопустимые символы');
            }
        }

        return $patronymic;
    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param string|null $birthDate
     * @return self
     */
    public function setBirthDate(?string $birthDate): self
    {
        try {
            $this->birthDate = $birthDate ? Carbon::parse($birthDate) : null;
        } catch (Exception $e) {
            echo 'Дата рождения содержит неверный формат данных';
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @return self
     */
    public function setGender(): self
    {
        if (!empty($this->patronymic)) {
            foreach (UserDataEnums::GENDER_RELATION as $gender => $arEnd) {
                foreach ($arEnd as $end) {
                    $length = strlen($end);
                    if (!($length > 0) || substr($this->patronymic, -$length) === $end) {
                        $this->gender = $gender;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return self
     */
    public function setAge(): self
    {
        $this->age = $this->birthDate ? $this->birthDate->diffInYears(Carbon::now(), false) : null;
        if ($this->age < 0) {
            $this->age = null;
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @return self
     */
    public function setAgeGrade(): self
    {
        if (empty($this->age) && !empty($this->birthDate)) {
            $this->setAge();
        } elseif (empty($this->birthDate)) {
            return $this;
        }

        if (!empty($this->age)) {
            foreach (UserDataEnums::AGE_RELATION as $age => $name) {
                if ($age === UserDataEnums::AGE_LONG_LIVER && $this->age >= $age) {
                    $this->ageGrade = $name;
                    break;
                } elseif ($this->age <= $age) {
                    $this->ageGrade = $name;
                    break;
                }
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgeGrade(): ?string
    {
        return $this->ageGrade;
    }
}
