<template>
  <!-- 
      <div class="card collapsed-card card-warning card-outline">
          <div class="card-header border-transparent">
            <h3 class="card-title">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Biens</font>
              </font>
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
         
          <div class="card-body">
         
          
          </div>
  </div>-->
  <div class="conteiner">
    <!-- Button trigger modal-->

    <div class="card collapsed-card card-warning card-outline">
      <div class="card-header border-transparent">
        <h3 class="card-title">
          <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">liste des biens Loués</font>
          </font>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row mt-5" v-if="$gate.isAdminOrBailleurs()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">liste des biens Loués</h3>

                <div class="card-tools">
                  <!-- <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter Equipement
                  </button>-->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="table2" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Propriétaire</th>
                      <th>type</th>
                      <th>Valeur</th>
                      <th>adresse</th>
                      <th>locataire</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="biens in Biens.data" :key="biens.bein_id">
                      <td>{{biens.name}}</td>
                      <td>{{biens.libelle}}</td>
                      <td>{{biens.prix}}</td>
                      <td>{{biens.adresse}}</td>
                      <td>{{biens.adresse}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="Biens" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdminOrBailleurs()">
      <not-found></not-found>
    </div>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    setTimeout(function() {
      $("#table2").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
      });
    }, 2000);
  },
  components: {
    "not-found": notFoundComponentVue
  },
  data() {
    return {
      Biens: {}
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/bienslouer?page=" + page).then(response => {
        this.Biens = response.data;
      });
    }
  }
};
</script>
