<?php

 
class ControllerRest
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
 
    public function getResultPhotos() 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_photos WHERE is_deleted = 0');

        $stmt->execute();
        return $stmt;
    }

    public function getResultStores() 
    {
        $stmt = $this->pdo->prepare('SELECT tbl_storefinder_stores.store_id,
                                            tbl_storefinder_stores.store_name,
                                            tbl_storefinder_stores.store_address,
                                            tbl_storefinder_stores.store_desc,
                                            tbl_storefinder_stores.lat,
                                            tbl_storefinder_stores.lon,
                                            tbl_storefinder_stores.sms_no,
                                            tbl_storefinder_stores.phone_no,
                                            tbl_storefinder_stores.email,
                                            tbl_storefinder_stores.website,
											tbl_storefinder_stores.buy_ticket,
											tbl_storefinder_stores.date_for_ordering,
                                            tbl_storefinder_stores.category_id,
                                            tbl_storefinder_stores.created_at,
                                            tbl_storefinder_stores.updated_at,
                                            tbl_storefinder_stores.featured,
                                            tbl_storefinder_stores.is_deleted,
                                            COALESCE(SUM(tbl_storefinder_ratings.rating), 0) as rating_total, 
                                            COALESCE(COUNT(tbl_storefinder_ratings.rating), 0) as rating_count
                                            
                                    FROM tbl_storefinder_stores 
                                    LEFT OUTER JOIN tbl_storefinder_ratings 
                                    ON tbl_storefinder_stores.store_id = tbl_storefinder_ratings.store_id 
                                    WHERE is_deleted = 0 GROUP BY tbl_storefinder_stores.store_id');
        $stmt->execute();
        return $stmt;
    }

    public function getResultCategories() 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE is_deleted = 0 ORDER BY category_id ASC');		
        $stmt->execute();
        return $stmt;
    }
    public function getResultNews() 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_news WHERE is_deleted = 0');
        $stmt->execute();
        return $stmt;
    }

    public function getResultReviews($tmpFrom, $tmpTo, $store_id) 
    {
        $stmt = $this->pdo->prepare('SELECT review_id, review, tbl_storefinder_reviews.created_at, thumb_url, photo_url, username, full_name 
                                        FROM tbl_storefinder_reviews 
                                        INNER JOIN tbl_storefinder_users ON 
                                                        tbl_storefinder_reviews.user_id = tbl_storefinder_users.user_id 

                                        WHERE is_deleted = 0 AND created_at >= :tmpFrom AND created_at <= :tmpTo AND store_id = :store_id');
        
        $stmt->execute(
                        array('tmpFrom' => $tmpFrom,
                                    'tmpTo' => $tmpTo,
                                    'store_id' => $store_id) );
        return $stmt;
    }

    public function getResultStoresRating($store_id) 
    {
        $stmt = $this->pdo->prepare('SELECT *, SUM(rating) as rating_total, COUNT(rating) as rating_count 
                                    FROM tbl_storefinder_stores 
                                    LEFT OUTER JOIN tbl_storefinder_ratings 
                                    ON tbl_storefinder_stores.store_id = tbl_storefinder_ratings.store_id 
                                    WHERE is_deleted = 0 AND tbl_storefinder_stores.store_id = :store_id GROUP BY tbl_storefinder_stores.store_id');
        $stmt->execute(
                        array('store_id' => $store_id) );

        return $stmt;
    }


    public function getResultReviewsCount($count, $store_id) 
    {
        $stmt = $this->pdo->prepare('(SELECT review_id, review, tbl_storefinder_reviews.created_at, thumb_url, photo_url, full_name 
                                        FROM tbl_storefinder_reviews 
                                        INNER JOIN tbl_storefinder_users ON 
                                                        tbl_storefinder_reviews.user_id = tbl_storefinder_users.user_id 

                                        WHERE is_deleted = 0 AND store_id = :store_id ORDER BY review_id DESC LIMIT :count) ORDER BY review_id ASC');
        
        $stmt->execute(
                        array( 'count' => $count,
                                    'store_id' => $store_id) );
        return $stmt;
    }

    public function getResultReviewsTotalCount($store_id) 
    {
        $stmt = $this->pdo->prepare('SELECT review_id, review, tbl_storefinder_reviews.created_at, thumb_url, photo_url, full_name 
                                        FROM tbl_storefinder_reviews 
                                        INNER JOIN tbl_storefinder_users ON 
                                                        tbl_storefinder_reviews.user_id = tbl_storefinder_users.user_id 

                                        WHERE is_deleted = 0 AND store_id = :store_id');
        
        $stmt->execute(
                        array( 'store_id' => $store_id) );

        $count = $stmt->rowCount();
        return $count;
    }
	public function getResultTicket() 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_ticket');		
        $stmt->execute();
        return $stmt;
    }
}
 
?>