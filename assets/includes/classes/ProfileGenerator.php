<?php
require_once("ProfileData.php");
class ProfileGenerator {

    

    private $con, $userLoggedInObj, $profileData;

    public function __construct($con, $userLoggedInObj, $profileUsername) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->profileData = new ProfileData($con, $profileUsername);
    }

    
    

    public function create() {
        $profileUsername = $this->profileData->getProfileUsername();
        
        if(!$this->profileData->userExists()) {
            return "User does not exist";
        }

        $coverPhotoSection = $this->createCoverPhotoSection();
        $headerSection = $this->createHeaderSection();
        $tabsSection = $this->createTabsSection();
        $contentSection = $this->createContentSection();
        return "<div class='profileContainer'>
                    $coverPhotoSection
                    $headerSection
                    $tabsSection
                    $contentSection
                </div>";
    }

    public function createCoverPhotoSection() {
        $coverPhotoSrc = $this->profileData->getCoverPhoto();
        $name = $this->profileData->getProfileUserFullName();
        return "<div class='coverPhotoContainer'>
                    <img src='$coverPhotoSrc' class='coverPhoto'>
                    <span class='channelName'>$name</span>
                </div>";
    }

    public function createHeaderSection() {
        $profileImage = $this->profileData->getProfilePic();
        $name = $this->profileData->getProfileUserFullName();
        $profileUsername = $this->profileData->getProfileUsername();
        $form="";
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == $profileUsername){ $form .="<form id='profileForm' action='profile.php?username=$profileUsername' method='POST' enctype='multipart/form-data'>
        <input type='file' id='file' required name='fileInput' onchange='getImagePre(event);'>
    </form>";}else{
        $form.=" ";
    }
    
        $button = $this->createHeaderButton();
    
        return "<div class='profileHeader'>
    <div class='userInfoContainer'  onmouseover='showFileInput()' onmouseout='hideFileInput()'>
        <img class='profileImage' src='$profileImage'>
        $form
        <div class='userInfo'>
            <span class='title'>$name</span>
        </div>
    </div>

    <div class='buttonContainer'>
        <div class='buttonItem'>    
            $button
        </div>
    </div>
</div>

";

    }
    

    public function createTabsSection() {
        
        return "<ul class='nav nav-tabs' role='tablist'>
                    <li class='nav-item'>
                    <a class='nav-link active' id='videos-tab' data-toggle='tab' 
                        href='#videos' role='tab' aria-controls='videos' aria-selected='true'>ARTWORKS</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' id='about-tab' data-toggle='tab' href='#about' role='tab' 
                        aria-controls='about' aria-selected='false'>ABOUT</a>
                    </li>
                </ul>";
    }

    public function createContentSection() {

        $artworks = $this->profileData->getUsersArtworks();

        if(sizeof($artworks) > 0) {
            $artGrid = new artGrid($this->con, $this->userLoggedInObj);
            $artGridHtml = $artGrid->create($artworks, null, false);
        }
        else {
            $artGridHtml = "<span>This user has no Artworks</span>";
        }

        $aboutSection = $this->createAboutSection();

        return "<div class='tab-content channelContent'>
                    <div class='tab-pane fade show active' id='videos' role='tabpanel' aria-labelledby='videos-tab'>
                        $artGridHtml
                    </div>
                    <div class='tab-pane fade' id='about' role='tabpanel' aria-labelledby='about-tab'>
                        $aboutSection
                    </div>
                </div>";
    }

    private function createHeaderButton() {
        if($this->userLoggedInObj->getUsername() == $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            return "";
        }
    }

    private function createAboutSection() {
        $html = "<div class='section'>
                    <div class='title'>
                        <span>Details</span>
                    </div>
                    <div class='values'>";

        $details = $this->profileData->getAllUserDetails();
        foreach($details as $key => $value) {
            $html .= "<span>$key: $value</span>";
        }

        $html .= "</div></div>";

        return $html;
    }
}
?>