<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Twitter API</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <h2>Twitter API</h2>

      <form action="{{ route('post.tweet') }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        @if (count($errors))
          <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
              @foreach ($errors->all as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="form-group">
          <textarea name="tweet" class="form-control" placeholder="What's happening?"></textarea>
        </div>
        <div class="form-group">
          <input type="file" name="images[]" multiple class="form-control">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Tweet</button>
        </div>
      </form>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="50px">No</th>
            <th>Twitter Id</th>
            <th>Message</th>
            <th>Images</th>
            <th>Favorites</th>
            <th>Retweet</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($data))
            @foreach ($data as $key => $value)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $value['id'] }}</td>
                <td>{{ $value['text'] }}</td>
                <td>
                  @if (!empty($value['extended_entities']['media']))
                    @foreach ($value['extended_entities']['media'] as $v)
                      <img src="{{ $v['media_url_https'] }}" style="width: 100px;"/>
                    @endforeach
                  @endif
                </td>
                <td>{{ $value['favorite_count'] }}</td>
                <td>{{ $value['retweet_count'] }}</td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="6">There are no data</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </body>
</html>
