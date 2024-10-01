    <?php
    require_once __DIR__ . '/../config/database.php';

    class Experience {
        private $conn;
        private $table_name = "experiences";

        public $id_experience;
        public $job;
        public $date_start;
        public $date_end;
        public $company_name;
        public $company_address;
        public $description;
        public $profils_id_profil;

        public function __construct() {
            $this->conn = (new Database())->getConnection();
        }

        public function getTableName() {
            return $this->table_name;
        }

        public function getConnection() {
            return $this->conn;
        }
    }
