<?php
require "Entity.php";

/**
 *
 * @property string $name 姓名
 * @property string $sex 性别
 * @property int $age 年龄
 */
class Student extends Entity
{

    /**
     * @var string $intType
     */
    const INT_TYPE = 'intval';

    /**
     * @var string $StringType
     */
    const STRING_TYPE = 'strval';

    const ARRAY_TYPE = 'array';

    /**
     * @var array DATA_TYPE
     */
    const DATA_TYPE = [
        self::INT_TYPE,
        self::STRING_TYPE,
    ];

    private $_rule = [
        'name' => self::STRING_TYPE,
        'age' => self::INT_TYPE,
        'sex' => self::STRING_TYPE,
    ];

    public function __set($name, $value)
    {
        if (is_array($value)) {
            $this->$name = $value;
        }

        if (isset($name, $this->_rule)) {
            $this->$name = $this->_toType($value, $this->_rule[$name]);
        }

    }

    private function _toType($value, $type)
    {
        if (in_array($type, self::DATA_TYPE)) {
            $val = $type($value);
        } else {
            $val = strval($value);
        }

        return $val;
    }


}