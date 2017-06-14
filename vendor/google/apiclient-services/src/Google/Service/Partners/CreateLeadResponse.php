<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Partners_CreateLeadResponse extends Google_Model
{
  protected $leadType = 'Google_Service_Partners_Lead';
  protected $leadDataType = '';
  public $recaptchaStatus;
  protected $responseMetadataType = 'Google_Service_Partners_ResponseMetadata';
  protected $responseMetadataDataType = '';

  public function setLead(Google_Service_Partners_Lead $lead)
  {
    $this->lead = $lead;
  }
  public function getLead()
  {
    return $this->lead;
  }
  public function setRecaptchaStatus($recaptchaStatus)
  {
    $this->recaptchaStatus = $recaptchaStatus;
  }
  public function getRecaptchaStatus()
  {
    return $this->recaptchaStatus;
  }
  public function setResponseMetadata(Google_Service_Partners_ResponseMetadata $responseMetadata)
  {
    $this->responseMetadata = $responseMetadata;
  }
  public function getResponseMetadata()
  {
    return $this->responseMetadata;
  }
}
