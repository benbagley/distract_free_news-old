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
    this.load('hackernews')
  }
})
