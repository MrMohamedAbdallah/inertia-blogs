import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, usePage } from "@inertiajs/inertia-react";
import BlogsRow from "@/Components/BlogsRow";

export default function Dashboard({ blogs }) {
    const props = usePage().props;
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="my-8 text-right">
                <Link
                    href={route("blogs.create")}
                    className="px-4 py-2 text-sm text-white rounded bg-slate-900 hover:bg-slate-800"
                >
                    Create New Blog
                </Link>
            </div>

            <BlogsRow className="pb-10 mt-4" blogs={blogs} />
        </AuthenticatedLayout>
    );
}
