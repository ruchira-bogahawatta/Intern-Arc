<?php

class AjaxModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function searchCompanyFunction($searchItem)
    {

        // PDC - Company search including deactivated companies
        // Prepare Query
        $this->db->query('SELECT user_tbl.username, user_tbl.user_id, user_tbl.email, company_tbl.company_name, company_tbl.contact 
        FROM company_tbl 
        JOIN user_tbl ON user_tbl.user_id = company_tbl.user_id_fk
        WHERE blacklisted = 0 AND (company_tbl.company_name LIKE CONCAT("%", :companyName, "%")) 
        LIMIT 10');

        // Bind Values
        $this->db->bind(':companyName', $searchItem);

        $result = $this->db->resultset();
        //Execute
        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function searchStudentByIndex($searchItem, $batchYear, $stream)
    {

        // PDC - Company search including deactivated companies
        // Prepare Query
        $this->db->query('SELECT st.index_number, u.user_id
        FROM student_tbl st
        JOIN user_tbl u ON u.user_id = st.user_id_fk 
        WHERE st.stream = :stream AND st.batch_year = :batchYear AND st.index_number LIKE CONCAT("%", :indexNumber, "%") 
        LIMIT 10');

        // Bind Values
        $this->db->bind(':indexNumber', $searchItem);
        $this->db->bind(':batchYear', $batchYear);
        $this->db->bind(':stream', $stream);

        $result = $this->db->resultset();
        //Execute
        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function searchAdvertisementByBatchYear($searchItem, $batchYear)
    {

        // PDC - search advertisments by batch year
        // Prepare Query
        $this->db->query("SELECT advertisement_tbl.intern_count, advertisement_tbl.position, advertisement_tbl.advertisement_id, company_tbl.company_name, advertisement_tbl.status
        FROM company_tbl 
        JOIN advertisement_tbl 
        ON company_tbl.company_id = advertisement_tbl.company_id_fk 
        WHERE advertisement_tbl.batch_year = :batchYear 
        AND (advertisement_tbl.position LIKE CONCAT('%', :adPosition, '%') OR company_tbl.company_name LIKE CONCAT('%', :companyName, '%'))
        LIMIT 10");

        // Bind Values
        $this->db->bind(':adPosition', $searchItem);
        $this->db->bind(':companyName', $searchItem);
        $this->db->bind(':batchYear', $batchYear);

        $result = $this->db->resultset();
        //Execute
        if ($this->db->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getStudentRequestsByRound($searchItem, $batchYear, $round, $stream)
    {

        $this->db->query('SELECT sr.*, st.*, a.*, c.*, st.status as student_status
        FROM student_requests_tbl sr
        JOIN student_tbl st ON sr.student_id = st.student_id
        JOIN advertisement_tbl a ON sr.advertisement_id = a.advertisement_id
        JOIN company_tbl c ON a.company_id_fk = c.company_id
        WHERE st.index_number LIKE CONCAT("%", :searchItem, "%") 
        AND sr.batch_year = :batch_year 
        AND sr.round = :round 
        AND st.stream = :stream
        GROUP BY sr.student_id
        LIMIT 10');
        $this->db->bind(':searchItem', $searchItem);
        $this->db->bind(':batch_year', $batchYear);
        $this->db->bind(':round', $round);
        $this->db->bind(':stream', $stream);
        return $this->db->resultset();
    }
}
