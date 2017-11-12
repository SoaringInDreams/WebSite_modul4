<?php

class Articles extends Model{

    public function getList($alias, $order = 'date_news'){
        $sql = "select * from news where category = '$alias' order by '{$order}' desc";
        return $this->db->query($sql);
    }

    public function getListNewsCarousel($limit = 3){
        $sql = "select * from news order by date_news desc limit {$limit}";
        return $this->db->query($sql);
    }

    public function getListNews(){
        $sql = "select * from news order by date_news desc";
        return $this->db->query($sql);
    }
    public function getListNewsLimit($cat=null){
        $sql = (is_null($cat)) ? "SELECT * FROM news" : "SELECT * FROM news WHERE category = '{$cat}' ORDER BY date_news DESC LIMIT 5 ";
        return $this->db->query($sql);
    }

    public function getByTitle($alias){
        $alias = $this->db->escape($alias);
        $sql = "select * from news where title_news = '{$alias}'";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getCategory(){
        $sql = "select * from category";
        return $this->db->query($sql);
    }

    public function getCatById($alias){
        $alias = $this->db->escape($alias);
        $sql = "select * from category where name_category = '{$alias}'";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getById($id){
        $id = (int)$id;
        $sql = "select * from news where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getByIdCat($id){
        $id = (int)$id;
        $sql = "select * from category where id_category = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getListAdmin($only_published = false){
        $sql = "select * from news where 1";
        if ( $only_published ){
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public function save($data, $id = null){
        if ( !isset($data['title_news']) || !isset($data['category']) || !isset($data['content_news']) || !isset($data['image_news']) || !isset($data['date_news']) || !isset($data['id_category']) || !isset($data['is_published'])){
            return false;
        }

        $id = (int)$id;
        $title_news = $this->db->escape($data['title_news']);
        $category = $this->db->escape($data['category']);
        $content_news = $this->db->escape($data['content_news']);
        $image_news = $this->db->escape($data['image_news']);
        $date_news = $this->db->escape($data['date_news']);
        $id_category = $this->db->escape($data['id_category']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if ( !$id ){ // Add new record
            $sql = "
                insert into news
                   set title_news = '{$title_news}',
                       category = '{$category}',
                       content_news = '{$content_news}',
                       image_news = '{$image_news}',
                       date_news = '{$date_news}',
                       id_category = '{$id_category}',
                       is_published = {$is_published}
            ";
        } else { // Update existing record
            $sql = "
                update news
                   set title_news = '{$title_news}',
                       category = '{$category}',
                       content_news = '{$content_news}',
                       image_news = '{$image_news}',
                       date_news = '{$date_news}',
                       id_category = '{$id_category}',
                       is_published = {$is_published}
                   where id = {$id}
            ";
        }

        return $this->db->query($sql);
    }

    public function save_cat($data, $id = null){
        if ( !isset($data['name_category'])){
            return false;
        }

        $id = (int)$id;
        $name_category = $this->db->escape($data['name_category']);

        if ( !$id ){ // Add new record
            $sql = "
                insert into category
                   set name_category = '{$name_category}'
            ";
        }

        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete from news where id = {$id}";
        return $this->db->query($sql);
    }

    public function delete_category($id){
        $id = (int)$id;
        $sql = "delete from category where id_category = {$id}";
        return $this->db->query($sql);
    }

}