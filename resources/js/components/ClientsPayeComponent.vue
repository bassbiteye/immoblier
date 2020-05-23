<template>
  <div class="conteiner">
    <div class="card collapsed-card card-warning card-outline">
      <div class="card-header border-transparent">
        <h3 class="card-title">
          <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">Client Payé</font>
          </font>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="row mt-5" v-if="$gate.isAdminOrBailleurs()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <label for class="float-left">
                  rechercher par mois
                  <input
                    type="month"
                    class="form-control"
                    placeholder="Référence"
                    v-model="form.date"
                  />
                </label>
                <label for="">
                <button class="btn btn-secondary" @click="getResults()">rechercher</button>
                </label>

                <div class="card-tools"></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="table3" class="table table-hover">
                  <thead>
                    <tr>
                      <th>nom</th>
                      <th>prenom</th>
                      <th>telephone</th>
                      <th>profession</th>
                      <th>date de paiement</th>
                      <th>montant Payé</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="client in clientsPaye" :key="client.operation_id">
                      <td>{{client.nom}}</td>
                      <td>{{client.prenom}}</td>
                      <td>{{client.tel}}</td>
                      <td>{{client.profession}}</td>
                      <td>{{client.montant}}</td>

                      <td>{{client.updated_at | myDate}}</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
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

    setTimeout(function() {
      $("#table3").DataTable({
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
      clientsPaye: {},

      form: new Form({
        date: ""
      })
      // Create a new form instance
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults() {
      this.form.post("api/clientpaye").then(response => {
        this.clientsPaye = response.data;
      });
    }
  }
};
</script>
