require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',

    data() {
        return {
            showTodoCreateForm: false,
            showTodoEditForm: false,

            sortValue: undefined,

            todoForm: {
                id: '',
                description: ''
            },

            todoFormErrors: {},
            todos: []
        }
    },

    mounted() {
        this.fetchTodos();
    },

    methods: {
        fetchTodos () {
            if (this.sortValue !== undefined){
                this.sortTodos(this.sortValue);
            } else {
                axios.get('/api/todo')
                    .then(response => {
                        this.todos = response.data.data;
                    });
            }
        },

        editTodo (todo) {
            if (this.showTodoCreateForm === false){
                this.showTodoEditForm = true;
                this.todoFormErrors = {};
                this.todoForm.id = todo.id;
                this.todoForm.description = todo.description;
            }
        },

        cancelEdit () {
            this.showTodoEditForm = false;
            this.showTodoCreateForm = false;
            this.todoFormErrors = {};
            this.todoForm.id = '';
            this.todoForm.description = '';
        },

        saveTodo (todo) {
            this.todoFormErrors = {};

            if (!this.todoForm.description) {
                Vue.set(this.todoFormErrors, 'description' , 'A feladat neve nem lehet üres!');
                return false;
            }

            let saveRequest;
            if (_.isUndefined(todo)) {
                saveRequest = axios.post('/api/todo', this.todoForm);
            } else {
                saveRequest = axios.put(`/api/todo/${todo.id}`, this.todoForm);
            }

            saveRequest.then((response) => {
                if (todo) {
                    this.fetchTodos();
                } else {
                    this.todos.push(response.data.data);
                }
                this.todoForm.id = '';
                this.todoForm.description = '';
                this.todoForm.completed = '';
                this.showTodoEditForm = false;
                this.showTodoCreateForm = false;
            })

            .catch((error) => {
                let errors = error.response.data.errors;
                _.forEach(errors, (messages, field) => {
                    Vue.set(this.todoFormErrors, field, messages[0]);
                });
            });
        },

        deleteTodo(todo,id) {
            let del = confirm("Biztosan törölni akarja a feladatot?");
            if (del === true) {
                axios.delete(`/api/todo/${id}`)
                    .then(response => {
                        this.fetchTodos();
                    }).catch((error) => {
                    console.log(error);
                })
            }
        },

        toggleComplete(todo) {
            axios.put(`/api/todo/${todo.id}/toggle-complete`)
                .then(response => {
                    todo.completed = response.data.data.completed;
                    this.fetchTodos();
                })
        },

        sortTodos(value) {
            this.sortValue = value;
            if (value === undefined) {
                this.fetchTodos()
            } else {
                axios.get(`/api/todo/sort/${value}`)
                    .then(response => {
                        this.todos = response.data.data;
                    });
            }
        },
    }
});
