Vue.filter('truncate', function(value, length) {
  if(value.length < length) {
    return value;
  }

  length = length - 3;

  return value.substring(0, length) + '...';
});

var app = new Vue({
  el: '#app',
  delimiters: ['${', '}'],
  data: {
    items: [],
    loading: false
  },
  methods: {
    load (service) {
      this.loading = true,

      axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf_name"]').getAttribute('content');

      axios.get('/api/news/' + service).then((response) => {
        this.items = response.data
        this.loading = false
      });
    }
  },
  mounted () {
    this.load('bbcnews')
  }
});

$(document).ready(function(){
  // click functionality.
  $(".bars").click(function(){
    if($(".mobile-nav").hasClass("opened")){
      // If the nav is shown, then close it...
      $(".mobile-nav").slideToggle(400, function(){
        $(".mobile-nav").removeClass("opened");
      })
    } else {
      // otherwise if the nav is closed, open it.
      $(".mobile-nav").slideToggle(400, function(){
        $(".mobile-nav").addClass("opened");
      });
    } // close if-statement
  });

  $('nav a').on('click', function() {
    $('nav a').removeClass('active');
    $(this).toggleClass('active');
  });
});
