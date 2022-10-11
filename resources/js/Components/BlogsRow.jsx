import React from "react";
import { Link } from "@inertiajs/inertia-react";
import BlogCard from "./BlogCard";

export default function BlogsRow({ blogs, className }) {
    return (
        <div>
            <div
                className={
                    "grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 " +
                    className
                }
            >
                {blogs.data.map((blog) => (
                    <BlogCard key={blog.id} blog={blog} />
                ))}
            </div>
            <div className="flex items-center justify-between my-10">
                <Link
                    href={blogs.links.prev}
                    disabled={!blogs.links.prev}
                    as="button"
                    className="px-4 py-2 text-sm text-white bg-indigo-900 rounded disabled:opacity-70 disabled:cursor-not-allowed hover:bg-indigo-800"
                >
                    Previous
                </Link>
                <Link
                    href={blogs.links.next}
                    disabled={!blogs.links.next}
                    as="button"
                    className="px-4 py-2 text-sm text-white bg-indigo-900 rounded disabled:opacity-70 disabled:cursor-not-allowed hover:bg-indigo-800"
                >
                    Next
                </Link>
            </div>
        </div>
    );
}
