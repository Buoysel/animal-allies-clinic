<?php

/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/13/2017
 * Time: 12:41 PM
 */
class AnimalAlliesCustomPost {
    // slug of each custom post type
    private $slugs = array(
        'wish_list' => 'wish_list_post',
        'staff'     => 'staff_post',
        'services'  => 'services_post',
        'faq'       => 'faq_post',
        'carousel'  => 'aa_carousel_post',
        'message'   => 'message_post',
        'sponsors'  => 'aa_sponsors',
    );

    // general names of each custom post type
    private $names = array(
        'wish_list' => 'Wish List',
        'staff'     => 'Staff List',
        'services'  => 'Services',
        'faq'       => 'FAQ',
        'carousel'  => 'News',
        'message'   => 'Messages',
        'sponsors'  => 'Sponsors',
    );

    // taxonomy keys for each custom post type
    private $taxonomies = array(
        'wish_list' => 'wish_list_category',
        'staff'     => 'staff_category',
        'faq'       => 'faq_category',
    );

    public function getSlug($post) {
        return $this->slugs[$post];
    }

    public function getName($post) {
        return $this->names[$post];
    }

    public function getTaxonomy($post) {
        return $this->taxonomies[$post];
    }
}
