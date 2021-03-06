define({ "api": [
  {
    "type": "post",
    "url": "/user/:email",
    "title": "password Request User information",
    "name": "Login",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the User.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "password",
            "description": "<p>Password of the User.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "email",
            "description": "<p>Email of the User.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EmailOrPasswordIncorrect",
            "description": "<p>The email or password is incorrect.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://api.studentinfo.dev/user/:email"
      }
    ]
  },
  {
    "type": "post",
    "url": "/emails/:emails",
    "title": "",
    "name": "Login",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "emails",
            "description": "<p>Emails of the User.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "emails",
            "description": "<p>Emails of the User.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/RegisterController.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://api.studentinfo.dev/emails/:emails"
      }
    ]
  },
  {
    "type": "",
    "url": "{delete}",
    "title": "",
    "name": "Logout",
    "group": "User",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://api.studentinfo.dev{delete}"
      }
    ]
  }
] });