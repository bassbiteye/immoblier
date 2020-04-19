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
                  <th> type</th>
               
                </tr>
              </thead>
              <tbody>
                <tr v-for="typecomptes in typecomptes.data" :key="typecomptes.typeclient_id">
                  <td>{{typecomptes.libelle}}</td>
                
                  <td>
                    <a href="#" @click="editModal(typecomptes)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deletetypecomptes(typecomptes.typecomptes_id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="typecomptes" @pagination-change-page="getResults"></pagination>
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add new</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update typecomptes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updatetypecomptes() : createtypecomptes()">
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
import notFoundComponentVue from './notFoundComponent.vue';
export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
  
  },
  components: {
  'not-found': notFoundComponentVue
},
  data() {
    return {
      editmode: false,
      typecomptes: {},
      // Create a new form instance
      form: new Form({
        id:'',
        libelle: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/typecomptes?page=" + page).then(response => {
        this.typecomptes = response.data;
      });
    },
    updatetypecomptes(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/typecomptes/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadtypecomptes();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "le typecomptes bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(typecomptes) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(typecomptes);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deletetypecomptes(id) {
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
            .delete("api/typecomptes/" + id)
            .then(() => {
              Swal.fire("Suppression!", "le typecomptes bien été supprimé.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadtypecomptes() {
      if (this.$gate.isAdmin()) {
        axios.get("/api/typecomptes").then(({ data }) => (this.typecomptes = data));
      }
    },
    createtypecomptes() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/typecomptes")
        .then(() => {
          //this will update dom automatically
          //this.loadtypecomptes();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "typecomptes a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {

    this.loadtypecomptes();
    Fire.$on("AfterCreate", () => {
      this.loadtypecomptes();
    });
    //setInterval(()=>this.loadtypecomptes(),10000)
  }
};
</script>
