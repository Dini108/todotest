@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group list-group-flush">
                                    <div class="radio-group d-flex justify-content-center">
                                        <input type="radio" class="form-check-input" name="sort"
                                               id="option-one"
                                               @click="sortTodos(0)">
                                        <label for="option-one" class="form-check-label"> Elkészületlen feladatok
                                        </label>
                                        <input type="radio" class="form-check-input" name="sort"
                                               id="option-two"
                                               @click="sortTodos(1)">
                                        <label for="option-two" class="form-check-label"> Kész feladatok
                                        </label>
                                        <input type="radio" checked class="form-check-input" name="sort"
                                               id="option-three"
                                               @click="sortTodos()">
                                        <label for="option-three" class="form-check-label"> Összes
                                        </label>
                                    </div>
                                    <li class="list-group-item" v-for="todo in todos"
                                        :style="{textDecoration: todo.completed ? 'line-through' : ''}">
                                        <template v-if="todoForm.id !== todo.id">
                                            @{{ todo.description }}
                                            <span class="float-right">
                                            <button class="ml-3"
                                                    v-bind:class="[todo.completed ?
                                                                    'btn btn-danger' :
                                                                    'btn btn-success']"
                                                    @click="toggleComplete(todo)">

                                                <template v-if="todo.completed">
                                                    <i class="fas fa-minus-circle"></i>
                                                </template>
                                                <template v-else>
                                                    <i class="fas fa-check-circle"></i>
                                                </template>
                                            </button>
                                            <button class="btn ml-3 btn-info"
                                                    @click.prevent="deleteTodo(todo, todo.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn ml-3 btn-danger"
                                                    @click.prevent="editTodo(todo)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </span>
                                        </template>
                                        <div class="form-inline" v-else>
                                            <input class="form-control col-md-10" placeholder="Feladat neve"
                                                   v-model="todoForm.description"
                                                   :class="{'is-invalid': todoFormErrors.description}"
                                                   @keyup.enter="saveTodo(todoForm)"
                                                   @keyup.esc="cancelEdit(todo)">
                                            <span class="float-right">
                                                <button class="btn ml-3 btn-danger"
                                                        @click.prevent="cancelEdit(todo)">
                                                    <i class="fas fa-window-close"></i>
                                                </button>
                                                <button class="btn ml-3 btn-success"
                                                        @click.prevent="saveTodo(todoForm)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </span>
                                            <div class="invalid-feedback" v-if="todoFormErrors.description">
                                                @{{ todoFormErrors.description }}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center"
                                     v-if="showTodoCreateForm === false && showTodoEditForm === false">
                                    <button class="btn btn-info" v-if="showTodoCreateForm === false"
                                            @click="showTodoCreateForm = true"><i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="form-inline" v-else-if="showTodoCreateForm === true">
                                    <input class="form-control col-md-10" placeholder="Feladat neve"
                                           v-model="todoForm.description"
                                           :class="{'is-invalid': todoFormErrors.description}"
                                           @keyup.enter="saveTodo()"
                                           @keyup.esc="cancelEdit()">
                                    <span class="float-right">
                                        <button class="btn ml-3 btn-danger"
                                                @click.prevent="cancelEdit()">
                                            <i class="fas fa-window-close"></i>
                                        </button>
                                        <button class="btn ml-3 btn-success"
                                                @click.prevent="saveTodo()">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </span>
                                    <div class="invalid-feedback" v-if="todoFormErrors.description">
                                        @{{ todoFormErrors.description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
