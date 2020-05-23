<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des types etats</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="table" class="table table-hover">
              <thead>
                <tr>
                  <th>type</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="typeetats in typeetats.data" :key="typeetats.id">
                  <td>{{typeetats.libelleE}}</td>

                  <td>
                    <a href="#" @click="editModal(typeetats)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a
                      href="#"
                      @click="deletetypeetats(typeetats.typeetats_id)"
                    >
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="typeetats" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updatetypeetats() : createtypeetats()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.libelleE"
                  type="text"
                  name="libelleE"
                  placeholder="libelle"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('libelleE') }"
                />
                <has-error :form="form" field="libelleE"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Modifier</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
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
      $("#table").DataTable({
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
      editmode: false,
      typeetats: {},
      // Create a new form instance
      form: new Form({
        id: "",
        libelleE: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/typeetats?page=" + page).then(response => {
        this.typeetats = response.data;
      });
    },
    updatetypeetats(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/typeetats/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadtypeetats();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "le typeetats bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(typeetats) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(typeetats);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deletetypeetats(id) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.form
            .delete("api/typeetats/" + id)
            .then(() => {
              Swal.fire(
                "Suppression!",
                "le typeetats bien été supprimé.",
                "success"
              );
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadtypeetats() {
      if (this.$gate.isAdmin()) {
        axios.get("/api/typeetats").then(({ data }) => (this.typeetats = data));
      }
    },
    createtypeetats() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/typeetats")
        .then(() => {
          //this will update dom automatically
          //this.loadtypeetats();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "typeetats a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.loadtypeetats();
    Fire.$on("AfterCreate", () => {
      this.loadtypeetats();
    });
    //setInterval(()=>this.loadtypeetats(),10000)
  }
};
</script>
