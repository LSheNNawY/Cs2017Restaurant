<?php
// Meals categories class
class  Meals_categories
{
    private $connection;

    // create connection
    public function __construct()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * add new category
     * @param $category_title
     * @return bool
     */
    public function addCategory($category_title)
    {
        // query
        $this->connection->query("INSERT INTO `meals_categories`( `category_title`) VALUES ('$category_title')");
        // check  the query
        if ($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * update category
     *  @param $category_id
     * @param $category_title
     * @return bool
     */
    public function updateCategory($category_id ,$category_title)
    {
        // query
        $this->connection->query("UPDATE `meals_categories` SET `category_title` = '$category_title' WHERE `category_id` = $category_id");
        // check the query
        if ($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * delete delet category
     * @param   $category_id
     * @return boolean
     */
    public function deletCategory($category_id)
    {
        // query
        $this->connection->query("DELETE FROM `meals_categories` WHERE `category_id` = $category_id");
        // check the query
        if ($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * get all Meals categories
     * @return array|null
     */
    public function getMealsCategories($extra='')
    {
        // query
        $result = $this->connection->query("SELECT * FROM `meals_categories` $extra");
        // check the query
        if ($result->num_rows > 0)
        {
            $meals_categories = array();

            while ($row = $result->fetch_assoc())
                $meals_categories[] = $row;

            return $meals_categories;
        }
        // return null if there is no meals_categories founded
        return null;
    }

    /**
     * get meals category by id function
     * @param  $category_id
     * @return array|null
     */
    public function getCategoryById($category_id)
    {
        $categories = $this->getMealscategories("WHERE `category_id` = $category_id");

        if ($categories && count($categories) > 0)
            return $categories[0];

        return null;
    }

     // end database connection
    public function __destruct()
    {
        $this->connection->close();
    }
}