/* Fetching Data */

function fetchData(tableName, storage) {
  console.log("Fetching data...");

  $.ajax({
    type: "GET",
    url: "_resources/php/getting-info.php",
    data: {
      tableName: tableName
    },

    success: function(data) { // Success.
      console.log("...fetch success.");

      var dataArray = JSON.parse(data);

      for (var i = 0; i < dataArray.length; i++) {
        storage.push(dataArray[i]);
      }
    },

    fail: function() { // Failure.
      console.log("...fetch failure.");
    },

    always: function() { // ALways.

    }
  });
}

/* Posting Data */

function postData(filename, data, action) {
  console.log(action + " data...");

  $.ajax({
    type: "POST",
    url: filename,
    data: data,

    success: function(data) { // Success.
      console.log("..." + action + " success.");
    },

    fail: function() { // Failure.
      console.log("..." + action + " failure.");
    },

    always: function() { // Always.

    }
  });
}
