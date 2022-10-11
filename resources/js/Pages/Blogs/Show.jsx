import React from "react";
import { Head, Link, useForm } from "@inertiajs/inertia-react";
import BaseLayout from "@/Layouts/BaseLayout.jsx";

export default function Show({ blog }) {
    const deleteForm = useForm();

    const deleteSubmit = () => {
        if (!confirm("Are you sure you want to delete that blog?")) return;
        deleteForm.delete(route("blogs.destroy", blog.data));
    };

    return (
        <>
            <Head title="blog.data.title">
                <meta name="description" content={blog.data.body} />
            </Head>

            <BaseLayout>
                <div className="max-w-4xl mx-auto my-8">
                    {blog.data.can.edit || blog.data.can.delete ? (
                        <div
                            className="flex items-center justify-between my-8"
                            v-if="blog.data.can.edit || blog.data.can.delete"
                        >
                            {blog.data.can.edit ? (
                                <Link
                                    href={route("blogs.edit", blog.data)}
                                    className="px-4 py-2 text-sm text-white rounded bg-slate-900 hover:bg-slate-800"
                                >
                                    Edit
                                </Link>
                            ) : null}

                            {blog.data.can.delete ? (
                                <button
                                    onClick={deleteSubmit}
                                    className="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-500"
                                >
                                    Delete
                                </button>
                            ) : null}
                        </div>
                    ) : null}
                    <h1 className="mb-4 text-2xl font-bold lg:text-7xl">
                        {blog.data.title}
                    </h1>
                    <div className="max-w-xl mx-auto mb-8">
                        {!!blog.data.cover ? (
                            <img
                                src={blog.data.cover}
                                alt={blog.data.title}
                                className="w-full rounded-lg"
                            />
                        ) : null}
                    </div>
                    <div
                        dangerouslySetInnerHTML={{ __html: blog.data.bodyHTML }}
                        className="prose lg:prose-xl"
                    ></div>
                </div>
            </BaseLayout>
        </>
    );
}
