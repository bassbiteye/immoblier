<template>
  <div class="conteiner">
    <!-- bien -->

    <div class="row mt-5" v-if="$gate.isAdminOrBailleurs()">
      <div class="col-md-12" v-if="showTab">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des locations</h3>

            <div class="card-tools">
              <!-- <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter Equipement
              </button>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Nom complet</th>
                  <th>adresse</th>
                  <th>Bien</th>
                  <th>prix</th>
                  <th>Caution</th>
                  <th>numero</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="operation in Operation.data" :key="operation.id">
                  <td>{{operation.prenom}} {{operation.nom}}</td>
                  <td>{{operation.adresse}}</td>
                  <td>{{operation.details}}</td>
                  <td>{{operation.prix}}</td>
                  <td>{{operation.caution}}</td>
                  <td>{{operation.numero}}</td>

                  <td>
                    <button class="btn btn-success" @click="detail(operation)">
                      <i class="fas fa-rent-plus fa fw"></i> detail
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="Operation" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdminOrBailleurs()">
      <not-found></not-found>
    </div>
    <section class="content" v-if="detailShow">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> ALAWA.
                    <small class="float-right">Date: {{date|myDate}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h3>propriétaire</h3>
                  <address>
                    <strong>alawa.</strong>
                    <br />alawa
                    <br />alawa
                    <br />Phone: alawa
                    <br />Email: info@alawa.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>locataire</h3>
                  <address>
                    <strong>{{details.prenom}}</strong>
                    <strong>{{details.nom}}</strong>

                    <br />
                    Phone: {{details.tel}}
                    <br />
                    sexe: {{details.sexe}}
                    <br />
                    adresse: {{details.adresse}}
                    <br />
                    profession: {{details.profession}}
                    <br />
                    nationalité: {{details.nationalite}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>Bien</h3>

                  <b>Bien:</b>
                  {{details.details}}
                  <br />
                  <b>Prix:</b>
                  {{details.prix}}
                  <br />
                  <b>Adresse:</b>
                  {{details.adresse}}
                  <br />
                  <b>référence:</b>
                  {{details.numero}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row no-print" @click="piece(details.piece)" v-if="details.piece">
                <div class="col-12">
                  <button type="button" class="btn btn-primary float-right">
                    <i class="fas fa-print"></i>
                    piece
                  </button>
                </div>
              </div>
              <div
                class="row no-print"
                @click="dernier(details.dernierelevé)"
                v-if="details.dernierelevé"
              >
                <div class="col-12">
                  <button type="button" class="btn btn-success float-right">
                    <i class="fas fa-download"></i>
                    dernier relevé
                  </button>
                </div>
              </div>
              <div class="row no-print" @click="Revoquer(details)">
                <div class="col-12">
                  <button type="button" class="btn btn-danger float-right">
                    <i class="fas fa-trash"></i>
                    Revoquer
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
  },
  components: {
    "not-found": notFoundComponentVue
  },
  data() {
    return {
      Operation: {},
      details: {},
      detailShow: false,
      showTab: true,
      date: new Date(),
      form: new Form({
        numero: "",
        operation_id: "",
        biens: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/revoque?page=" + page).then(response => {
        this.Operation = response.data;
      });
    },
    dernier(e) {
      window.open("img/profile/" + e);
    },
    piece(e) {
      window.open("img/profile/" + e);
    },

    Revoquer(e) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Révoquer!",
        cancelButtonText: "Annuler"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.form
            .post("/api/addrevoque")
            .then(() => {
              Swal.fire("success!", "Révocation avec success.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
      this.$Progress.start();
      this.detailShow = false;
    },
    detail(e) {
      this.detailShow = true;
      this.details = e;
    },

    created() {
      this.loadOperation();
      Fire.$on("AfterCreate", () => {
        this.loadOperation();
      });
      //setInterval(()=>this.loadOperation(),10000)
    }
  }
};
</script>
