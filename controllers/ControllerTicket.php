<?php

class ControllerTicket
{
 
    private $db;
    private $pdo;
    function __construct() 
    {
        // connecting to database
        $this->db = new DB_Connect();
        $this->pdo = $this->db->connect();
    }
 
    function __destruct() { }
 
    public function updateTicket($itm) 
    {
		$stmt = $this->pdo->prepare('SELECT * 
                                FROM tbl_storefinder_ticket');
        
        $stmt->execute();
		
		$count = $stmt->rowCount();
		
		
		if ($count > 0) {
		
			$stmt = $this->pdo->prepare('UPDATE tbl_storefinder_ticket
	
											SET ticket_url = :ticket_url');
			
		
		} else {
		
			$stmt = $this->pdo->prepare('INSERT INTO tbl_storefinder_ticket( 
											ticket_url ) 
	
										VALUES(
											:ticket_url )');
											
		}

        $result = $stmt->execute(
                            array('ticket_url' => $itm->ticket_url ) );
        
        return $result ? true : false;

    }


    public function getTicket() 
    {
        
        $stmt = $this->pdo->prepare('SELECT * 
                                FROM tbl_storefinder_ticket');
        
        $stmt->execute();

        foreach ($stmt as $row) 
        {
            $itm = new Ticket();
            $itm->ticket_url = $row['ticket_url'];

            return $itm;
        } 
        
        return null;
    }

}
 
?>