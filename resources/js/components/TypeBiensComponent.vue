<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des Typebiens</h3>

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
                <tr v-for="typebiens in Typebiens.data" :key="typebiens.id">
                  <td>{{typebiens.libelle}}</td>
                
                  <td>
                    <a href="#" @click="editModal(typebiens)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteTypebiens(typebiens.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="Typebiens" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div v-if="!$gate.isAdminOrAuthor()">
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
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Typebiens</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateTypebiens() : createTypebiens()">
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
  data() {
    return {
      editmode: false,
      Typebiens: {},
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
      axios.get("api/typebiens?page=" + page).then(response => {
        this.Typebiens = response.data;
      });
    },
    updateTypebiens(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/typebiens/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadTypebiens();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "le typebiens bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(typebiens) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(typebiens);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteTypebiens(id) {
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
            .delete("api/typebiens/" + id)
            .then(() => {
              Swal.fire("Suppression!", "le typebiens bien été supprimé.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadTypebiens() {
      if (this.$gate.isAdminOrAuthor()) {
        axios.get("/api/typebiens").then(({ data }) => (this.Typebiens = data));
      }
    },
    createTypebiens() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/typebiens")
        .then(() => {
          //this will update dom automatically
          //this.loadTypebiens();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "Typebiens a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {

    this.loadTypebiens();
    Fire.$on("AfterCreate", () => {
      this.loadTypebiens();
    });
    //setInterval(()=>this.loadTypebiens(),10000)
  }
};
</script>
