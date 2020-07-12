"use strict";
var PostMaker = document.createElement("form");
PostMaker.setAttribute("method", "post");
PostMaker.setAttribute("id", "PostMaker");
PostMaker.setAttribute("name", "PostMaker");
PostMaker.setAttribute("action", "upload_post.php");
PostMaker.setAttribute("enctype", "multipart/form-data");
document.body.appendChild(PostMaker);

var TitleBox = document.createElement("input");
TitleBox.setAttribute("name", "PostTitle");
TitleBox.setAttribute("type", "text");
TitleBox.setAttribute("placeholder", "Post Title")
PostMaker.appendChild(TitleBox);
PostMaker.appendChild(document.createElement("br"));

var TagBox = document.createElement("input");
TagBox.setAttribute("name", "Tags");
TagBox.setAttribute("type", "text");
TagBox.setAttribute("placeholder", "Tags, seperated, by, commas")
PostMaker.appendChild(TagBox);
PostMaker.appendChild(document.createElement("br"));
//Array to store all the section parent nodes
//This is so they can be easily referenced and iterated through later
var Sections = Array();
//run the addSection function so the first section gets made
addSection();
//make button to add sections, this should stay at bottom of form
var addSectionButton = document.createElement("button");
addSectionButton.setAttribute("id", "addSectionButton");
addSectionButton.setAttribute("type", "button");
addSectionButton.setAttribute("onclick", "addSection()");
addSectionButton.innerHTML = "Add Section";
PostMaker.appendChild(addSectionButton);
//Makes and attaches submit button
var submitButton = document.createElement("button");
submitButton.innerHTML = "Submit Post";
submitButton.setAttribute("name", "submit");
submitButton.setAttribute("type", "submit");
submitButton.setAttribute("value", "Submit");
PostMaker.appendChild(document.createElement("br"));
PostMaker.appendChild(submitButton);


function addSection(){
    var sectionDiv = document.createElement("div");
    //the Div's id should be equal to its array position
    sectionDiv.setAttribute("id", "sectionDiv" + Sections.length);
    sectionDiv.setAttribute("class", "Section");
    Sections.push(sectionDiv);
    //Attach the new section div as a child of the PostMaker form
    //but before the add section button to keep the button at the bottom
    PostMaker.insertBefore(Sections[Sections.length - 1], addSectionButton);
    //Make div for images for the section and append it to the section's div
    var imgDiv = document.createElement("div");
    imgDiv.setAttribute("id", "ImgDiv" + (Sections.length - 1));
    Sections[Sections.length - 1].appendChild(imgDiv);
    //Make image button and attach it to the section
    var addImageButton = document.createElement("button");
    addImageButton.setAttribute("type", "button");
    addImageButton.innerHTML = "Add Image";
    addImageButton.setAttribute("onclick", "addImage(" + (Sections.length - 1) + ")");
    Sections[Sections.length - 1].appendChild(addImageButton);
    //Make remove image button and attach it to the section
    var removeImageButton = document.createElement("button");
    removeImageButton.setAttribute("type", "button");
    removeImageButton.innerHTML = "Remove Image";
    removeImageButton.setAttribute("onclick", "removeImage(" + (Sections.length - 1) + ")");
    Sections[Sections.length - 1].appendChild(removeImageButton);
    Sections[Sections.length - 1].appendChild(document.createElement("br"));
    //Make the textarea for the section and add it to the new section's div
    var textInput = document.createElement("textarea");
    textInput.setAttribute("id", "sectionText" + (Sections.length - 1));
    textInput.setAttribute("name", "Section" + (Sections.length - 1));
    textInput.setAttribute("placeholder", "Section " + (Sections.length - 1) + " Text");
    //Append the textArea as a child of the section's div
    Sections[Sections.length - 1].appendChild(textInput);
    //Put a button on the section to remove it
    var removeSectionButton = document.createElement("button");
    removeSectionButton.setAttribute("type", "button");
    removeSectionButton.innerHTML = "Remove Section";
    removeSectionButton.setAttribute("onclick", "removeSection(" + (Sections.length - 1) + ")");
    Sections[Sections.length - 1].appendChild(removeSectionButton);
    Sections[Sections.length - 1].appendChild(document.createElement("br"));
}

function removeSection(sectionNumber){
    //Remove section @sectionNumber and splice it from the array
    PostMaker.removeChild(Sections[sectionNumber]);
    console.log("sectionNumber" + sectionNumber)
    Sections.splice(sectionNumber, 1);
    //Go through all the sections one index up and decrement them by 1
    var i = sectionNumber;
    for (i ; i <= Sections.length; i++) {
        //iterate through the children of the image div
        //iterate through the rest of the children in the section div
        console.log(Sections[i].children);
        Sections[i].setAttribute("id", "sectionDiv" + i);
        Sections[i].childNodes[0].setAttribute("id", "imgDiv" + i);
        Sections[i].childNodes[1].setAttribute("onclick", "addImage(" + i + ")");
        Sections[i].childNodes[2].setAttribute("onclick", "removeImage(" + i + ")");
        Sections[i].childNodes[4].setAttribute("id", "sectionText" + i);
        Sections[i].childNodes[4].setAttribute("placeholder", "Section " + i + " Text");
        Sections[i].childNodes[5].setAttribute("onclick", "removeSection(" + i + ")");
    }
}

function addImage(sectionNumber){
    if (Sections[sectionNumber].childNodes[0].childNodes.length < 3){
        //array for the images
        Sections[sectionNumber].childNodes[0].childNodes;
        //Image element
        var imgUpload = document.createElement("input");
        imgUpload.setAttribute("type", "file");
        imgUpload.setAttribute("name", "Section" + sectionNumber + "Img" + Sections[sectionNumber].childNodes[0].childNodes.length);
        Sections[sectionNumber].childNodes[0].appendChild(imgUpload);
    }else{
        alert("No more than 3 images per section please & ty");
    }
}

function removeImage(sectionNumber){
    Sections[sectionNumber].childNodes[0].removeChild(Sections[sectionNumber].childNodes[0].lastChild);
}
//Event handler for form validation
document.getElementById("PostMaker").onsubmit = function() {
    return isValidForm();
}
//function for form validation
function isValidForm(){
    var x = document.forms["PostMaker"]["PostTitle"].value;
    if (x == "") {
        alert("Post Title must be filled out");
        return false;
    }
}