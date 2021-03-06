<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/
/**
 * Home Controller
 *
 * @package Dashboard
 */
 
/**
 * Manages default info, error, and site status pages.
 *
 * @since 2.0.0
 * @package Dashboard
 */
class HomeController extends Gdn_Controller {
   /**
    * JS & CSS includes for all methods in this controller.
    * 
    * @since 2.0.0
    * @access public
    */
   public function Initialize() {
      $this->Head = new HeadModule($this);
      $this->AddJsFile('jquery.js');
      $this->AddJsFile('jquery.livequery.js');
      $this->AddJsFile('jquery.form.js');
      $this->AddJsFile('jquery.popup.js');
      $this->AddJsFile('jquery.gardenhandleajaxform.js');
      $this->AddJsFile('global.js');
      $this->AddCssFile('admin.css');
      $this->MasterView = 'empty';
      parent::Initialize();
   }

   /**
    * Display dashboard welcome message.
    * 
    * @since 2.0.0
    * @access public
    */
   public function Index() {
      $this->View = 'FileNotFound';
      $this->FileNotFound();
   }
   
   /**
    * A standard 404 File Not Found error message is delivered when this action
    * is encountered.
    * 
    * @since 2.0.0
    * @access public
    */
   public function FileNotFound() {
      if ($this->DeliveryMethod() == DELIVERY_METHOD_XHTML) {
         header("HTTP/1.0 404", TRUE, 404);
         $this->Render();
      } else
         $this->RenderException(NotFoundException());
   }
   
   /**
    * Display 'site down for maintenance' page.
    * 
    * @since 2.0.0
    * @access public
    */
   public function UpdateMode() {
      header("HTTP/1.0 503", TRUE, 503);
      $this->SetData('UpdateMode', TRUE);
      $this->Render();
   }
   
   /**
    * Display 'content deleted' page.
    * 
    * @since 2.0.0
    * @access public
    */
   public function Deleted() {
      header("HTTP/1.0 410", TRUE, 410);
      $this->Render();
   }
   
   /**
    * Display TOS page.
    * 
    * @since 2.0.0
    * @access public
    */
   public function TermsOfService() {
      $this->Render();
   }
   
   /**
    * Display privacy info page.
    * 
    * @since 2.0.0
    * @access public
    */
   public function PrivacyPolicy() {
      $this->Render();
   }
   
   /**
    * Display 'no permission' page.
    * 
    * @since 2.0.0
    * @access public
    */
   public function Permission() {
      if ($this->DeliveryMethod() == DELIVERY_METHOD_XHTML) {
         header("HTTP/1.0 401", TRUE, 401);
         $this->Render();
      } else
         $this->RenderException(PermissionException());
   }
   
}