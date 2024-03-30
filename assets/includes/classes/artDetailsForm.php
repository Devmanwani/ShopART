<?php class artDetailsForm {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createUploadForm(){
        $fileInput=$this->createFileInput();
        $titleInput=$this->createTitleInput(null);
        $descInput=$this->createDescInput(null);
        $categoriesInput=$this->createCategoriesInput(null);
        $uploadInput=$this->createUploadButton();
        $priceInput = $this->createPriceInput(null);

    return
        "<form action='processing.php' method='POST' enctype='multipart/form-data'>
            $fileInput
            $titleInput
            $descInput
            $priceInput
            $categoriesInput
            $uploadInput
        </form>";
    }

    public function createEditDetailsForm($art) {
        $titleInput = $this->createTitleInput($art->getTitle());
        $descriptionInput = $this->createDescInput($art->getDescription());
        $categoriesInput = $this->createCategoriesInput($art->getCategories());
        $priceInput  = $this->createPriceInput($art->getPrice());
        $saveButton = $this->createSaveButton();
        $deleteButton = $this->createDeleteButton();
        return "<form method='POST'>
                    $titleInput
                    $descriptionInput
                    $priceInput
                    $categoriesInput
                    $saveButton
                    $deleteButton
                </form>";
    }

    private function createFileInput(){
        return "<div>
                    <label for='file'><b>Add the artwork file</b>
                    </label><br>
                    <div id='Preview'></div>
                    <input type='file' id='file' required name='fileInput' onchange='getImagePreview(event)'>
                </div><br>";
    }

    private function createTitleInput($value) {
        if($value == null) $value = "";
        return "<div>
                    <input type='text' id='title' name='titleInput' placeholder='Title' value='$value' required>
                </div><br>";
    }

    private function createDescInput($value) {
        if($value == null) $value = "";
        return "<div>
                    <textarea name='descInput' id='desc' cols='70' rows='7' placeholder='Description' >$value</textarea>
                </div><br>";
    }

    private function createPriceInput($value){
        if($value == null) $value = "";
        return "<div>
                    <input type = 'number' id = 'Price' name ='Price' placeholder='Price' value='$value' required>
                    </div><br><br>";
    }



    private function createCategoriesInput($value) {
        if($value == null) $value = "";
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<br><div>
                    <label class='categories'> <b>Select Your category<b></label><br>
                    <select class='categories' name = 'categoriesInput'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $id = $row["id"];
            $name = $row["name"];
            $selected = ($id == $value) ? "selected='selected'" : "";

            $html .="<option $selected value='$id'>$name</option>";
                    

        }
        $html .="</select>
        </div>";
        return $html;
    }

    private function createUploadButton(){
        return "<br><button type='submit' name = 'uploadButton'>Upload</button>";
    }

    private function createSaveButton() {
        return "<button type='submit' class='btn btn-primary' name='saveButton'>Save</button>";
    }

    private function createDeleteButton(){
        return"<button type='submit' class='delete' name='deleteButton'>Delete</button>";
    }
}
?>