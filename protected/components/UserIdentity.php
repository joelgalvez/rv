<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
        private $_name;
    public function authenticate()
    {
        $record=User::model()->findByAttributes(array('email'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!==md5($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->id;
            $this->_name=$record->name;
            $this->setState('groupId', $record->groupId);
            $this->setState('categoryId', $record->categoryId);
            $this->setState('friendlyUrl', '/student/'.$record->friendlyName);
            if($record->year == '4') {
                $this->setState('isGraduating', 1);
            } else {
                $this->setState('isGraduating', 0);
            }

            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }
}