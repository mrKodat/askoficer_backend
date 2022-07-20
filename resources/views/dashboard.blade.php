@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervisor_account</i>
            </div>
            <h3 class="card-category">Users</h3>
            <h3 class="card-title">{{ $users }}
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/users">View all...</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">question_answer</i>
            </div>
            <p class="card-category">Questions</p>
            <h3 class="card-title">{{ $questions }}
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/questions">View all...</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">list_alt</i>
            </div>
            <p class="card-category">Categories</p>
            <h3 class="card-title">{{ $categories }}
    
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/categories">View all...</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">label</i>
            </div>
            <p class="card-category">Tags</p>
            <h3 class="card-title">{{ $tags }}
    
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/tags">View all...</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">chat</i>
            </div>
            <p class="card-category">Comments</p>
            <h3 class="card-title">{{ $comments }}
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/comments">View all...</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">flag</i>
            </div>
            <p class="card-category">Reports</p>
            <h3 class="card-title">{{ $reports }}
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/reports">View all...</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">mail</i>
            </div>
            <p class="card-category">Messages</p>
            <h3 class="card-title">{{ $messages }}
    
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <a href="/messages">View all...</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="row">
      <div class="col-md-4">
        <div class="card card-chart">
          <div class="card-header card-header-success">
            <div class="ct-chart" id="dailySalesChart"></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Daily Donations</h4>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i> updated 4 minutes ago
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-chart">
          <div class="card-header card-header-warning">
            <div class="ct-chart" id="websiteViewsChart"></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Email Subscriptions</h4>
            <p class="card-category">Last Campaign Performance</p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i> campaign sent 2 days ago
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-chart">
          <div class="card-header card-header-danger">
            <div class="ct-chart" id="completedTasksChart"></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Completed Tasks</h4>
            <p class="card-category">Last Campaign Performance</p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i> campaign sent 2 days ago
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="row">
      <div class="col-lg-6 col-md-10">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">Recently Published</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Date</th>
                <th>Title</th>
              </thead>
              <tbody>
                @foreach($recentQuestions as $question)
                <tr>
                  <td>{{ $question->created_at  }}</td>
                  <td><a href="/question-edit/{{ $question->id  }}">{{ $question->title  }}</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-10">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">Recent Comments</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>Date</th>
                <th>Comment</th>
              </thead>
              <tbody>
                @foreach($recentComments as $comment)
                <tr>
                  <td>{{ $comment->date  }}</td>
                  <td><a >{{ $comment->content  }}</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="copyright float-right">
            © Copyright 2021 by <a href="https://royhayek.com">Roy Hayek</a>. All Rights Reserved
        </div>
    </div>
</footer>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();
  });
</script>
@endpush