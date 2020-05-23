<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des types comptes</h3>

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
                <tr v-for="typeballieurs in typeballieurs.data" :key="typeballieurs.typeclient_id">
                  <td>{{typeballieurs.libelle}}</td>

                  <td>
                    <a href="#" @click="editModal(typeballieurs)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a
                      href="#"
                      @click="deletetypeballieurs(typeballieurs.typebailleurs_id)"
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
            <pagination :data="typeballieurs" @pagination-change-page="getResults"></pagination>
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
          <form @submit.prevent="editmode ? updatetypeballieurs() : createtypeballieurs()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.libelle"
                  type="text"
                  name="libelle"
                  placeholder="libelle"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('libelle') }"
                />
                <has-error :form="form" field="details"></has-error>
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
      typeballieurs: {},
      // Create a new form instance
      form: new Form({
        typebailleurs_id: "",
        libelle: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/typeballieurs?page=" + page).then(response => {
        this.typeballieurs = response.data;
      });
    },
    updatetypeballieurs(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/typeballieurs/" + this.form.typebailleurs_id)
        .then(() => {
          //this will update dom automatically
          //this.loadtypeballieurs();
          $("#addNew").modal("hide");
          Swal.fire(
            "Deleted!",
            "le typeballieurs bien été modifié.",
            "success"
          );
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(typeballieurs) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(typeballieurs);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deletetypeballieurs(id) {
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
            .delete("api/typeballieurs/" + id)
            .then(() => {
              Swal.fire(
                "Suppression!",
                "le typeballieurs bien été supprimé.",
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
    loadtypeballieurs() {
      if (this.$gate.isAdmin()) {
        axios
          .get("/api/typeballieurs")
          .then(({ data }) => (this.typeballieurs = data));
      }
    },
    createtypeballieurs() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/typeballieurs")
        .then(() => {
          //this will update dom automatically
          //this.loadtypeballieurs();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "typeballieurs a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.loadtypeballieurs();
    Fire.$on("AfterCreate", () => {
      this.loadtypeballieurs();
    });
    //setInterval(()=>this.loadtypeballieurs(),10000)
  }
};
</script>
