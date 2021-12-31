<aside class="control-sidebar control-sidebar-dark" style="display: none;">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Short Notice</h5>
      <p>{{$settings->where('key','short.notice')->first()['value']}}</p>
    </div>
  </aside>