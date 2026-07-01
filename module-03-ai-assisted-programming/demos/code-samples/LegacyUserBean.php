<?php

// Sample legacy code for Demo 2 (Legacy Explanation)
// Synthetic pre-framework PHP example — use for demo only

class LegacyUserBean
{
  private $firstName;
  private $lastName;
  private $errors = array();

  public function validateUser()
  {
    $this->errors = array();
    if ($this->firstName == null || trim($this->firstName) == '') {
      $this->errors[] = 'First name is required';
    }
    if ($this->lastName == null || trim($this->lastName) == '') {
      $this->errors[] = 'Last name is required';
    }
  }

  public function isValid()
  {
    return count($this->errors) == 0;
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }
}
