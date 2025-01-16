interface IProps {
    children: string;
    className: string;
}

export default function Label({ children, className = '', ...props }: IProps) {
    return (
        <label
            className={`${className} block text-gray-700`}
            {...props}>
            {children}
        </label>
    )
}
