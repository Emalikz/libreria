<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary" v-if="client">
                        Prestamo de libros a {{ client.first_name }}
                        {{ client.second_name }} {{ client.first_lastname }}
                        {{ client.second_lastname }}

                        <button
                            class="btn btn-success float-right"
                            @click="borrowBook()"
                        >
                            Guardar
                        </button>
                    </div>

                    <div class="card-body row">
                        <div
                            v-for="(book, index) of books"
                            class="col-md-4 mt-3"
                        >
                            <div class="card">
                                <div
                                    class="card-header"
                                    :class="[getCardHeaderColor(index)]"
                                >
                                    {{ book.title }}
                                </div>
                                <div class="card-body">
                                    <p>Autor: {{ book.author }}</p>
                                    <p>
                                        Número de páginas:
                                        {{ book.number_pages }}
                                    </p>
                                    <p>Código ISBN: {{ book.isbn_code }}</p>
                                    <button
                                        class="btn btn-success float-right"
                                        :class="{
                                            disabled: disabledBook(book)
                                        }"
                                        @click="addBorrowedBook(book)"
                                    >
                                        Prestar
                                    </button>
                                    <button
                                        class="btn btn-success float-left"
                                        :class="{
                                            disabled: disabledBookRefund(book)
                                        }"
                                        @click="addRefundedBook(book)"
                                    >
                                        Devolver
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <h2>Libros prestados</h2>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Autor</th>
                                        <th>Titulo</th>
                                        <th>ISBN</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(borrowedBook,
                                        index) in borrowedBooks"
                                    >
                                        <td>{{ borrowedBook.author }}</td>
                                        <td>{{ borrowedBook.title }}</td>
                                        <td>{{ borrowedBook.isbn_code }}</td>
                                        <td>
                                            <button
                                                class="btn btn-danger"
                                                @click="dropBorrowedBook(index)"
                                            >
                                                🗑
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="container mt-3">
                            <h2>Libros devuletos</h2>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Autor</th>
                                        <th>Titulo</th>
                                        <th>ISBN</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(refundedBook,
                                        index) in refundedBooks"
                                    >
                                        <td>{{ refundedBook.author }}</td>
                                        <td>{{ refundedBook.title }}</td>
                                        <td>{{ refundedBook.isbn_code }}</td>
                                        <td>
                                            <button
                                                class="btn btn-danger"
                                                @click="dropRefundedBook(index)"
                                            >
                                                🗑
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: ["client"],
    data: () => {
        return {
            books: null,
            borrowedBooks: [],
            refundedBooks: [],
            hasErrors: false
        };
    },
    async mounted() {
        const { data } = await axios.get("/borrows/books", {});
        this.books = data;
    },
    methods: {
        getCardHeaderColor(index) {
            return ["bg-info", "bg-warning", "bg-danger"][index % 3];
        },
        addBorrowedBook(book) {
            if (book.is_borrowed) {
                return Swal.fire({
                    text:
                        "No puedes prestar este libro, ya se encuentra prestado",
                    icon: "error"
                });
            }
            const indexBorrow = this.borrowedBooks.findIndex(
                b => b.id == book.id
            );
            console.log("indexBorrow :>> ", indexBorrow);
            if (indexBorrow > -1) {
                return Swal.fire({
                    text:
                        "No puedes prestar este libro, ya se encuentra en la lista de libros prestados",
                    icon: "error"
                });
            }
            this.borrowedBooks.push({ ...book });
        },
        disabledBook(book) {
            const indexBorrow = this.borrowedBooks.findIndex(
                b => b.id == book.id
            );
            return indexBorrow > -1 || book.is_borrowed;
        },
        dropBorrowedBook(index) {
            this.borrowedBooks.splice(index, 1);
        },
        async borrowBook() {
            const { data } = await axios.post("/borrows", {
                books: [...this.borrowedBooks.map(b => b.id)],
                refundedBooks: [...this.refundedBooks.map(b => b.id)],
                client: this.client.id
            });

            for (let e of data.borrowedBooks) {
                this.$toasted.show(e.message);
                this.hasErrors = true;
            }

            if (!this.hasErrors) {
                window.location.href = "/client";
            }
        },
        async addRefundedBook(book) {
            if (!book.is_borrowed) {
                return Swal.fire({
                    text:
                        "No puedes devolver este libro, no se encuentra prestado",
                    icon: "error"
                });
            }
            const indexBorrow = this.borrowedBooks.findIndex(
                b => b.id == book.id
            );
            if (indexBorrow > -1) {
                return Swal.fire({
                    text:
                        "No puedes devolver este libro, no se encuentra en la lista de libros prestados",
                    icon: "error"
                });
            }

            if (book.last_borrow.client_id != this.client.id) {
                const { dismiss, value } = await Swal.fire({
                    title: "Confirmación",
                    text:
                        "Este usuario no prestó este libro, seguro desea devolverlo de todas formas?",
                    showCancelButton: true,
                    cancelButtonText: "No.",
                    confirmButtonText: "Si, devolver."
                });
                if (dismiss) return;
            }
            this.refundedBooks.push({ ...book });
        },
        disabledBookRefund(book) {
            const indexRefund = this.refundedBooks.findIndex(
                b => b.id == book.id
            );
            return indexRefund > -1 || !book.is_borrowed;
        },
        dropRefundedBook(index) {
            this.refundedBooks.splice(index, 1);
        }
    }
};
</script>
