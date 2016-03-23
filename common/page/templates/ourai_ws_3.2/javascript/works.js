(function( window, $, undefined ) {

function orderByLatest( a, b ) {
  return -((new Date(a.updated_at)).getTime() - (new Date(b.updated_at)).getTime());
}

function repo( data ) {
  var item = $("<li>", { class: "repo" });

  item
    .append("<div />")
    .children("div")
    .append("<h2><a href=\"" + (data.homepage || data.html_url) + "\" rel=\"external nofollow\">" + data.name + "</a></h2>")
    .append("<span class=\"repo_lang\">" + (data.language || "none") + "</span>")
    .append("<time>Last updated: " + updateTime(data.updated_at) + "</time>")
    .append("<p>" + data.description + "</p>");

  return item;
}

function updateTime( time ) {
  var d = new Date(time);

  return d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " +
    d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
}

$.getJSON("https://api.github.com/users/ourai/repos", function( repos ) {
  if ( $.isArray(repos) ) {
    $(".repo_count").text(repos.length);

    repos.sort(orderByLatest);

    $.each(repos, function( i, r ) {
      $(".repos").append(repo(r));
    });
  }
});


})(window, jQuery);
