import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import { Head } from "@inertiajs/inertia-react";
import CreateEditBlog from "@/Components/Blogs/CreateEditBlog.jsx";

export default function Create() {
    return (
        <AuthenticatedLayout>
            <Head title="Create New Blog" />
            <CreateEditBlog />
        </AuthenticatedLayout>
    );
}
