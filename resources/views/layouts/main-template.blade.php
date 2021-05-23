
@include('layouts.header')
<script>
  let script = document.createElement('script');
  script.src = "{{ asset('js/templates/'.$action.'.js') }}";
  document.head.append(script);
  script.onerror = function() {
    alert("Error loading " + this.src);
  };
</script>
<body style="background: white; font-family: sans-serif; margin-bottom:80px">
    @include('templates.'.$action)
</body>
@include('layouts.footer')