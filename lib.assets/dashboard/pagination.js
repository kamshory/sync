function createData(selector, result) {
  let table = $(selector);
  let map = result.map;
  table.find('thead').empty();
  table.find('tbody').empty();
  let tbody = table.find('tbody');
  table.find('thead').append($('<tr>'));
  let tr = table.find('thead tr');
  for (let i in map) {
    let td = $('<td>');
    td.text(map[i].value);
    tr.append(td);
  }
  for (let j in result.data) {
    let trb = $('<tr>');
    for (let i in map) {
      let td = $('<td>');
      td.text(result.data[j][map[i].key]);
      trb.append(td);
    }
    tbody.append(trb);
  }
}

function parseQuery(search) {
  let args = search.substring(1).split('&');
  let argsParsed = {};
  let i, arg, kvp, key, value;
  for (i = 0; i < args.length; i++) {
    arg = args[i];
    if (-1 === arg.indexOf('=')) {
      //argsParsed[decodeURIComponent(arg).trim()] = true;
    }
    else {
      kvp = arg.split('=');
      key = decodeURIComponent(kvp[0]).trim();
      value = decodeURIComponent(kvp[1]).trim();
      argsParsed[key] = value;
    }
  }
  return argsParsed;
}


function createPagination(result) {
  let page = result.page;
  let totalPage = result.totalPage;
  let fullPath = window.location.toString();
  let baseName = fullPath.split(/[\\\/]/).pop();
  if (baseName.indexOf('?') != -1) {
    baseName = baseName.split('?')[0];
  }
  if (baseName.indexOf('#') != -1) {
    baseName = baseName.split('#')[0];
  }

  let range = result.pageRange;

  let min = page - range;
  if (min < 1) {
    min = 1;
  }
  let max = page + range;
  if (max > totalPage) {
    max = totalPage;
  }
  let prevPage = page - 1;
  let nextPage = page + 1;

  let pageList = [];
  pageList.push(createPageLink(baseName, page, prevPage, min, max, 'Prev'));
  for (let i = min; i <= max; i++) {
    pageList.push(createPageLink(baseName, page, i, min, max, i));
  }
  pageList.push(createPageLink(baseName, page, nextPage, min, max, 'Next'));
  return pageList.join('\r\n');
}

function createPageLink(baseName, currentPage, pageLink, min, max, caption) {
  let parsed = parseQuery(document.location.search);
  let li = $('<li>');
  li.addClass('page-item');
  if (pageLink < min || pageLink > max) {
    li.addClass('disabled');
  }
  if (pageLink == currentPage) {
    li.addClass('active');
  }
  li.attr({ 'data-page': pageLink });
  let a = $('<a>');
  a.addClass('page-link');
  a.text(caption);
  parsed.page = pageLink;

  let parsedArr = [];
  for (let i in parsed) {
    if (parsed.hasOwnProperty(i)) {
      parsedArr.push(encodeURIComponent(i) + '=' + encodeURIComponent(parsed[i]));
    }
  }

  a.attr({ 'href': baseName + '?' + parsedArr.join('&') });
  li.append(a);
  return li[0].outerHTML;
}

function loadAjax(url, page) {
  $.ajax({
    type: 'GET',
    url: url,
    data: { page: page },
    success: function (result) {
      buildPage(result);
    }
  });
}

function buildPage(result) {
  let paginationStr = createPagination(result);
  $('nav ul.pagination').each(function () {
    $(this).empty().append(paginationStr);
  });
  createData('table.table-data', result);
}