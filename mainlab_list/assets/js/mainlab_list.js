// Opens overview BRANCH.
$('.data-overview-item-branch').click(function() {
  var content = $('#' + $(this).attr('cid'));
  var icon    = $('#' + $(this).attr('iid'));
  var status = content.css("display");
  if (status == 'none') {
    icon.removeClass("data-overview-img-item-plus").addClass("data-overview-img-item-minus");
    content.show();
  }
  else {
    icon.removeClass("data-overview-img-item-minus").addClass("data-overview-img-item-plus");
    content.hide();
  }
});