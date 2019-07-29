$('#selectAllBoxes').click(function(event){
    if(this.checked){
        $('.checkBoxes').each(function(){
            this.checked = true;
        });
    }else{
        $('.checkBoxes').each(function(){
            this.checked = false;
        });
    }
});

/*validation for add-post form*/
$(document).ready(function() {
    $('#addPost').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        title: {
            validators: {
                notEmpty: {
                    message: 'The title is required and cannot be empty'
                },
                stringLength: {
                    max: 100,
                    message: 'The title must be less than 100 characters long'
                }
            }
        },
        post_category_id: {
            validators: {
                    notEmpty: {
                    message: 'Please select some category'
                }
            }
        },
        status: {
            validators: {
                    notEmpty: {
                    message: 'Please select post status'
                }
            }
        },
        image: {
            validators: {
                notEmpty: {
                    message: 'Image cannot be empty'
                }
            }
        },
        post_tags: {
            validators: {
                notEmpty: {
                        message: 'Please insert some tag related to the post'
                    }
            }
        },
        post_content: {
            validators: {
                notEmpty: {
                    message: 'Post content cannot be empty'
                },
                stringLength: {
                    min: 10,
                    max: 200,
                    message: 'Post content cannot be greater than 200 characters'
                }
            }
        },
        }
    });
});


/*validation for edit post form*/
$(document).ready(function() {
    $('#editPost').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        title: {
            validators: {
                notEmpty: {
                    message: 'The title is required and cannot be empty'
                },
                stringLength: {
                    max: 100,
                    message: 'The title must be less than 100 characters long'
                }
            }
        },
        post_category_id: {
            validators: {
                    notEmpty: {
                    message: 'Please select some category'
                }
            }
        },
        status: {
            validators: {
                    notEmpty: {
                    message: 'Please select post status'
                }
            }
        },
        image: {
            validators: {
                notEmpty: {
                    message: 'Image cannot be empty'
                }
            }
        },
        post_tags: {
            validators: {
                notEmpty: {
                        message: 'Please insert some tag related to the post'
                    }
            }
        },
        post_content: {
            validators: {
                notEmpty: {
                    message: 'Post content cannot be empty'
                },
                stringLength: {
                    min: 10,
                    max: 200,
                    message: 'Post content cannot be greater than 200 characters'
                }
            }
        },
        }
    });
});


/*validation for change password form*/
$(document).ready(function() {
    $('#changePassword').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            current_password: {
                validators: {
                    notEmpty: {
                        message: 'Enter Current Password'
                    }
                }
            },
            new_password: {
                validators: {
                        notEmpty: {
                            message: 'Please enter password'
                    },
                    identical: {
                        field: 'confirm_new_password',
                        message: 'Passwords do not match'
                    }
                }
            },
            confirm_new_password: {
                validators: {
                        notEmpty: {
                            message: 'Please confirm password'
                    },
                    identical: {
                        field: 'new_password',
                        message: 'Passwords do not match'
                    }
                }
            }
        }
    });
});




function loadUsersOnline(){
    $.get("functions.php?onlineusers=result", function(data){//ajax calls that takes echo as data; gets a part of data 
        $('.usersonline').text(data);
    });
}

setInterval(function(){
    loadUsersOnline();
}, 500);//refresh or recall the function after every 500 milliseconds