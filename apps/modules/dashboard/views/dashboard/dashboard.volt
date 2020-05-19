{% extends "../../layout/base.volt" %}
{% block content %}
<!-- Page Content -->
<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 60%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>

    <div class="content">
        <div class="row gutters-tiny invisible" data-toggle="appear">
            <!-- Row #4 -->

            {% for poli in daftar_poli %}
            {% if antri[poli] is defined %}
          
                                
                               <table id="myTable">
 
                                  <tr>
                                    <td>Poli </td>
                                    <td>:{{poli}} </td>
                                  </tr>
                                  <tr>
                                    <td>Antrian Saat ini </td>
                                    <td>: {{antri[poli]['sekarang']}}</td>
                                  </tr>
                                  {% if antri[poli]['kita'] is defined %}
                                  <tr>
                                    <td>Antrian Anda </td>
                                    <td>: {{antri[poli]['kita']}}</td>
                                  </tr>
                                  {% else %}
                                  <tr>
                                    <td>Antrian Anda </td>
                                    <td>: - </td>
                                  </tr>
                                  {% endif %}
                                  
                                </table>

                                <script>
                                function myFunction() {
                                  var input, filter, table, tr, td, i, txtValue;
                                  input = document.getElementById("myInput");
                                  filter = input.value.toUpperCase();
                                  table = document.getElementById("myTable");
                                  tr = table.getElementsByTagName("tr");
                                  for (i = 0; i < tr.length; i++) {
                                    td = tr[i].getElementsByTagName("td")[0];
                                    if (td) {
                                      txtValue = td.textContent || td.innerText;
                                      if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        tr[i].style.display = "";
                                      } else {
                                        tr[i].style.display = "none";
                                      }
                                    }       
                                  }
                                }
                                </script>
             
            {% endif %}
            {% endfor %}
    </div>
    <!-- END Page Content -->
{% endblock %}