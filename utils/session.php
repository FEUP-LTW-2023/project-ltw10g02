<?php
  class Session {
    private array $messages;
    private array $formValues;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      $this->formValues = isset($_SESSION['form_values']) ? $_SESSION['form_values'] : array();
      
      unset($_SESSION['messages']);
      unset($_SESSION['form_values']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function unset() {
        unset($_SESSION['messages']);
      }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? intval($_SESSION['id']) : null;    
    }

    public function getName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function getCategory() : ?string {
      return isset($_SESSION['category']) ? $_SESSION['category'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setName(string $name) {
      $_SESSION['name'] = $name;
    }
    
    public function setCategory(string $category) {
      $_SESSION['category'] = $category;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }

    /* store the values from the form inputs in the session */
    public function addFormValues(array $values) {
      $_SESSION['form_values'] = $values;
    }

    /* get the stored form input values */
    public function getFormValues() {
      return $this->formValues;
    }
  }
?>