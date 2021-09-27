<?php

namespace App\Entity;

use DateTime;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $birth_date;
    private int $sex;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birth_date;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return int
     */
    public function getSex(): int
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex(int $sex): void
    {
        $this->sex = $sex;
    }

    public function validateAttributes()
    {
        if (!isset($this->name) || !is_string($this->name)) {
            return false;
        }
        if (!isset($this->email) || filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (!isset($this->birth_date) || !$this->validateDate($this->birth_date)) {
            return false;
        }
        if (!isset($this->sex) || in_array($this->sex, [1, 2])) {
            return false;
        }
        return true;
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function getAttributes()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'sex' => $this->sex,
        ];
    }

    public function setAttributes(array $values)
    {
        $this->id = $values['id'];
        $this->name = $values['name'];
        $this->email = $values['email'];
        $this->birth_date = $values['birth_date'];
        $this->sex = $values['sex'];
    }
}