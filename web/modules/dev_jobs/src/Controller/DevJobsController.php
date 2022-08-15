<?php

namespace Drupal\dev_jobs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * An example controller.
 */
class DevJobsController extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function content(): array
  {

    $request_title = \Drupal::request()->request->get('title');
    $request_location = \Drupal::request()->request->get('location');
    $request_fulltime = \Drupal::request()->request->get('fulltime');


    $node_storage = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
    $node_storage->condition('type', 'devjobs')
    ->sort('created', 'DESC');

    if($request_title) {
      $node_storage->condition('title', $request_title, 'CONTAINS');
    }
    if($request_location){
      $nids = $node_storage->condition('field_location', $request_location, 'CONTAINS');
    }
    if($request_fulltime) {
      $nids = $node_storage->condition('field_job_type', '1', '=');
    }

    $nids = $node_storage->execute();

// create "timeago" function
    function get_timeago($ptime)
    {
      $estimate_time = time() - strtotime($ptime);
        if( $estimate_time < 1 ){
          return 'less then 1 second ago';
        }
      
      $condition= [
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
       ];
      
      foreach ( $condition as $secs => $str ) {
        $d = $estimate_time / $secs;
        if ( $d >= 1 ) {
          $r = round($d);
          return $r . $str . ($r > 1 ? 's' : '') . ' ago';
        }
      }
    }

    // Create jobs array
    $jobs=[];
    foreach ( $nids as $nid ) {
      $node = Node::load($nid);
      $file_id = $node->field_thumbnail->target_id;
      $thumbnail_uri = File::load($file_id)->getFileUri();
      $url = ImageStyle::load('thumbnail')->buildUrl($thumbnail_uri);
      $date = get_timeago($node->field_date->value);
      $jobs[$nid]=[
        'nid' => $nid,
        'company' => $node->field_company->value,
        'date' => $date,
        'thumbnail' => $url,
        'title' => $node->title->value,
        'job_type'=> $node->field_job_type->value,
      ];

    }
    return [
      '#theme' => 'dev_jobs_theme_hook',
      '#jobs' => $jobs,
    ];
  }
}
