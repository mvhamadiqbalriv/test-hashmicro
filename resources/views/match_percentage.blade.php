@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100 p-5">
        <div class="card-header">
            <h6 class="text-capitalize">Match Percentage</h6>
        </div>
        <div class="card-body">
            <form id="match-percentage">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="">Input 1</label>
                            <input type="text" name="input_1" class="form-control">
                            <small class="text-danger" id="input_1_validation"></small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="">Input 2</label>
                            <input type="text" name="input_2" class="form-control">
                            <small class="text-danger" id="input_2_validation"></small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="">Type</label>
                            <select name="type" class="form-select" id="">
                                <option value="1">With Case</option>
                                <option value="2">Ignore Case</option>
                            </select>
                            <small class="text-danger" id="input_2_validation"></small>
                        </div>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Count !</button>
                    </div>
                </div>
            </form>
            <div class="row text-center" id="result" style="display: none">
                <h5>Result :</h5>
                <b id="result_percentage"></b><br>
                <b id="result_description"></b>
            </div>
        </div>
      </div>
    </div>
  </div>

  <script>

    function hideValidation() {
        const validation = document.querySelectorAll(`[id$="_validation"]`)
        for(var i = 0; i < validation.length; i++){
            
            validation[i].style.display = "none";
        }
    }

    let match_percentage = document.getElementById('match-percentage');

    match_percentage.addEventListener('submit', (e) => {
        e.preventDefault();
        
        let input_1 = match_percentage.input_1.value;
        let input_2 = match_percentage.input_2.value;
        let type = match_percentage.type.value;

        let formData = new FormData();
        formData.append('input_1', input_1);
        formData.append('input_2', input_2);
        formData.append('type', type);

        fetch("{{route('match-percentage.calculate')}}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{csrf_token()}}"
            }
        })
        .then(response => response.json())
        .then(resp => {
            if (resp.status == true) {
                console.log(resp.char);
                document.getElementById('result').style.display = 'block';
                if(resp.data.char.length > 0){
                    document.getElementById('result_description').style.display = 'block';
                    document.getElementById('result_description').textContent = resp.data.char+' is on the second input';
                }else{
                    document.getElementById('result_description').style.display = 'none';
                }
                document.getElementById('result_percentage').textContent = resp.data.result+'%';
            }else{
                document.getElementById('result').style.display = 'none';
                if (resp.data) {
                    var error = Object.entries(resp.data);
                    hideValidation()
                    error.forEach((key,value) => {
                        document.getElementById(key[0]+'_validation').style.display = 'block';
                        document.getElementById(key[0]+'_validation').textContent = key[1];
                    });
                }
            }
        })

    })
  </script>
@endsection