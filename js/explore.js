var apiUrl = "../librarian/server";
var repeat = false;

var apiCall = {
  search : function(query) {
    var url = apiUrl +'/search.php?query=' + query;
    return Promise.resolve($.ajax(url));
  },

  get : function(id) {
    var url = apiUrl + '/get.php?id=' + id;
    return Promise.resolve($.ajax(url));
  },

  related: function(id) {
      var url = apiUrl + '/recommend.php?id=' + id;
      return Promise.resolve($.ajax(url));
  }
}


function init() {
  apiCall.get("mO-62VxpLe0C").then(createRootNode);
}

function createRootNode(node) {
  dndTree.setRootBook(node);
  // console.log(node);
}

window.onresize = function () {
    dndTree.resizeOverlay();
    var height = $(window).height();
    $('#rightpane').height(height);
};

$('#rightpane').height($(window).height());


init();

function getRelated(node, exclude) {
    // console.log(node);
    return new Promise(function (resolve, reject) {
        // TODO remove repeat artists
        return apiCall.related(node.id).then(function (data) {
            if (!repeat) {
                console.log(data);
                data.books = data.books.filter(function (books) {
                    return exclude.indexOf(books.id) === -1;
                });
            }
            resolve(data.books);
        });
    });
}

function searchBook() {
  // console.log($("#movie-search").val());
  apiCall.search($("#book-search").val())
         .then(function (data) {
          //  console.log(data);
         if (data && data.length) {
          //  console.log("Here");
            console.log(data[0]);
             createRootNode(data[0]);
         }
     });
}

window.AE = {
    getRelated: getRelated,
    apiUrl: apiUrl
};
