dayjs.extend(window.dayjs_plugin_relativeTime);
dayjs().format();

function slideToggle(t, e, o) { 0 === t.clientHeight ? j(t, e, o, !0) : j(t, e, o) } function slideUp(t, e, o) { j(t, e, o) } function slideDown(t, e, o) { j(t, e, o, !0) } function j(t, e, o, i) { void 0 === e && (e = 400), void 0 === i && (i = !1), t.style.overflow = "hidden", i && (t.style.display = "block"); var p, l = window.getComputedStyle(t), n = parseFloat(l.getPropertyValue("height")), a = parseFloat(l.getPropertyValue("padding-top")), s = parseFloat(l.getPropertyValue("padding-bottom")), r = parseFloat(l.getPropertyValue("margin-top")), d = parseFloat(l.getPropertyValue("margin-bottom")), g = n / e, y = a / e, m = s / e, u = r / e, h = d / e; window.requestAnimationFrame(function l(x) { void 0 === p && (p = x); var f = x - p; i ? (t.style.height = g * f + "px", t.style.paddingTop = y * f + "px", t.style.paddingBottom = m * f + "px", t.style.marginTop = u * f + "px", t.style.marginBottom = h * f + "px") : (t.style.height = n - g * f + "px", t.style.paddingTop = a - y * f + "px", t.style.paddingBottom = s - m * f + "px", t.style.marginTop = r - u * f + "px", t.style.marginBottom = d - h * f + "px"), f >= e ? (t.style.height = "", t.style.paddingTop = "", t.style.paddingBottom = "", t.style.marginTop = "", t.style.marginBottom = "", t.style.overflow = "", i || (t.style.display = "none"), "function" == typeof o && o()) : window.requestAnimationFrame(l) }) }

let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
for (var i = 0; i < sidebarItems.length; i++) {
  let sidebarItem = sidebarItems[i];
  sidebarItems[i].querySelector('.sidebar-link').addEventListener('click', function (e) {
    e.preventDefault();

    let submenu = sidebarItem.querySelector('.submenu');
    if (submenu.classList.contains('active')) submenu.style.display = "block"

    if (submenu.style.display == "none") submenu.classList.add('active')
    else submenu.classList.remove('active')
    slideToggle(submenu, 300)
  })
}

/**
 * Sidebar Wrapper
 */
const Sidebar = function (sidebarEL) {
  /**
   * Sidebar Element
   * @param  {HTMLElement} sidebarEL
   */
  this.sidebarEL = sidebarEL instanceof HTMLElement ? sidebarEL : document.querySelector(sidebarEL);

  /**
   * Init Sidebar
   */
  this.init = function () {
    // add event listener to sidebar
    document.querySelector('.burger-btn').addEventListener('click', this.toggle.bind(this));
    document.querySelector('.sidebar-hide').addEventListener('click', this.toggle.bind(this));
    window.addEventListener('resize', this.onResize.bind(this));

    // Perfect Scrollbar Init
    if (typeof PerfectScrollbar == 'function') {
      const container = document.querySelector(".sidebar-wrapper");
      const ps = new PerfectScrollbar(container, {
        wheelPropagation: false
      });
    }

    // check responsive
    this.OnFirstLoad();

    // 
    return this;
  }

  /**
   * OnFirstLoad
   */
  this.OnFirstLoad = function () {
    var w = window.innerWidth;
    if (w < 1200) {
      this.sidebarEL.classList.remove('active');
    }
  }

  /**
   * OnRezise Sidebar
   */
  this.onResize = function () {
    var w = window.innerWidth;
    if (w < 1200) {
      this.sidebarEL.classList.remove('active');
    } else {
      this.sidebarEL.classList.add('active');
    }
    // reset 
    this.deleteBackdrop();
    this.toggleOverflowBody(true);
  }

  /**
   * Toggle Sidebar
   */
  this.toggle = function () {
    const sidebarState = this.sidebarEL.classList.contains('active');
    if (sidebarState) {
      this.hide();
    } else {
      this.show();
    }
  }

  /**
   * Show Sidebar
   */
  this.show = function () {
    this.sidebarEL.classList.add('active');
    this.createBackdrop();
    this.toggleOverflowBody();
  }

  /**
   * Hide Sidebar
   */
  this.hide = function () {
    this.sidebarEL.classList.remove('active');
    this.deleteBackdrop();
    this.toggleOverflowBody();
  }


  /**
   * Create Sidebar Backdrop
   */
  this.createBackdrop = function () {
    this.deleteBackdrop();
    const backdrop = document.createElement('div');
    backdrop.classList.add('sidebar-backdrop');
    backdrop.addEventListener('click', this.hide.bind(this));
    document.body.appendChild(backdrop);
  }

  /**
   * Delete Sidebar Backdrop
   */
  this.deleteBackdrop = function () {
    const backdrop = document.querySelector('.sidebar-backdrop');
    if (backdrop) {
      backdrop.remove();
    }
  }

  /**
   * Toggle Overflow Body
   */
  this.toggleOverflowBody = function (active) {
    const sidebarState = this.sidebarEL.classList.contains('active');
    const body = document.querySelector('body');
    if (typeof active == 'undefined') {
      body.style.overflowY = sidebarState ? 'hidden' : 'auto';
    } else {
      body.style.overflowY = active ? 'auto' : 'hidden';
    }
  }
}


/**
 * Create Sidebar Wrapper
*/
let sidebarEl = document.getElementById('sidebar');
if (sidebarEl) {
  window.sidebar = new Sidebar(sidebarEl).init();
}

function createDataTable(id, url, opt, btnFunc) {
  let table;
  //
  // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
  //
  $.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend({
      pages: 5, // number of pages to cache
      url: '', // script url
      data: null, // function or object with parameters to send to the server
      // matching how `ajax.data` works in DataTables
      method: 'GET' // Ajax HTTP method
    }, opts);

    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;

    return function (request, drawCallback, settings) {
      var ajax = false;
      var requestStart = request.start;
      var drawStart = request.start;
      var requestLength = request.length;
      var requestEnd = requestStart + requestLength;

      if (settings.clearCache) {
        // API requested that the cache be cleared
        ajax = true;
        settings.clearCache = false;
      } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
        // outside cached data - need to make a request
        ajax = true;
      } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
        JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
        JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
      ) {
        // properties changed (ordering, columns, searching)
        ajax = true;
      }

      // Store the request for checking next time around
      cacheLastRequest = $.extend(true, {}, request);

      if (ajax) {
        // Need data from the server
        if (requestStart < cacheLower) {
          requestStart = requestStart - (requestLength * (conf.pages - 1));

          if (requestStart < 0) {
            requestStart = 0;
          }
        }

        cacheLower = requestStart;
        cacheUpper = requestStart + (requestLength * conf.pages);

        request.start = requestStart;
        request.length = requestLength * conf.pages;

        // Provide the same `data` options as DataTables.
        if (typeof conf.data === 'function') {
          // As a function it is executed with the data object as an arg
          // for manipulation. If an object is returned, it is used as the
          // data object to submit
          var d = conf.data(request);
          if (d) {
            $.extend(request, d);
          }
        } else if ($.isPlainObject(conf.data)) {
          // As an object, the data given extends the default
          $.extend(request, conf.data);
        }

        return $.ajax({
          "type": conf.method,
          "url": conf.url,
          "data": request,
          "dataType": "json",
          "cache": false,
          "success": function (json) {
            cacheLastJson = $.extend(true, {}, json);

            if (cacheLower != drawStart) {
              json.data.splice(0, drawStart - cacheLower);
            }
            if (requestLength >= -1) {
              json.data.splice(requestLength, json.data.length);
            }

            drawCallback(json);
          }
        });
      } else {
        json = $.extend(true, {}, cacheLastJson);
        json.draw = request.draw; // Update the echo for each response
        json.data.splice(0, requestStart - cacheLower);
        json.data.splice(requestLength, json.data.length);

        drawCallback(json);
      }
    }
  };

  // Register an API method that will empty the pipelined data, forcing an Ajax
  // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
  $.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
      settings.clearCache = true;
    });
  });


  //
  // DataTables initialisation
  //
  let options = {
    "ordering": false,
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "ajax": $.fn.dataTable.pipeline({
      url: url,
      pages: 5 // number of pages to cache
    })
  }

  if (typeof opt != undefined) {
    for (let key in opt) {
      options[key] = opt[key]
    }
  }

  table = $(`#${id}`).DataTable(options);

  if (typeof btnFunc != undefined) {
    for (let key in btnFunc) {
      $(`#${id} tbody`).on('click', `#${key}`, function () {
        var cell = table.cell(this.parentNode);
        var data = table.row(cell.index().row).data()
        btnFunc[key](data);
      })
    }
  }
  return table;
}

const savedPages = []


const navigateTo = url => {
  history.pushState(null, null, url)
  router()
}

const router = async () => {
  Array.from(document.querySelectorAll(".sidebar-item"))
    .forEach(e => e.classList.remove("active"))

  let qs = location.search !== "" ? location.search : "?dashboard"

  document.querySelector(`a[href='${qs}'].sidebar-link`).parentNode.classList.add("active")
  document.querySelector('.sidebar-item.active').scrollIntoView(false)

  let page = savedPages.find(e => e.route.path === qs)
  if (!page) {
    page = {
      route: routes.find(r => r.path === qs)
    }
    page.content = await fetch(page.route.url).then(response => response.text())
    savedPages.push(page)
  }

  setInnerHTML(document.querySelector("#main-content"), page.content)
}

window.addEventListener("popstate", router)

document.addEventListener("DOMContentLoaded", () => {
  Array.from(document.querySelectorAll("[data-link]")).forEach(e => {
    e.addEventListener("click", e => {
      e.preventDefault()
      if (e.currentTarget.href === location.search) return
      navigateTo(e.currentTarget.href)
    })
  })

  router()
})

function setInnerHTML(elm, html) {
  elm.innerHTML = html;
  Array.from(elm.querySelectorAll("script")).forEach(oldScript => {
    const newScript = document.createElement("script");
    Array.from(oldScript.attributes)
      .forEach(attr => newScript.setAttribute(attr.name, attr.value));
    newScript.appendChild(document.createTextNode(oldScript.innerHTML));
    oldScript.parentNode.replaceChild(newScript, oldScript);
  });
}

function loadScript(scriptUrl) {
  const script = document.createElement('script');
  script.src = scriptUrl;
  document.body.appendChild(script);

  return new Promise((res, rej) => {
    script.onload = function () {
      res();
    }
    script.onerror = function () {
      rej();
    }
  });
}

function loadAllScripts(scripts, callback) {
  scripts = scripts.map(e => {
    return { url: e, loaded: false }
  });

  scripts.forEach(v => {
    loadScript(v.url).then(() => {
      v.loaded = true;
      if (!scripts.some(e => e.loaded === false)) {
        callback();
      }
    });
  })
}

function showToast(success, message) {
  let backgroundColor;
  if (success) {
    backgroundColor = "linear-gradient(135deg, #73a5ff, #5477f5)";
  } else {
    backgroundColor = "linear-gradient(to right, rgb(255, 95, 109), rgb(255, 195, 113))";
  }

  Toastify({
    text: message,
    duration: 3000,
    close: true,
    gravity: "top",
    position: "right",
    backgroundColor: backgroundColor,
    stopOnFocus: true,
  }).showToast();
}
