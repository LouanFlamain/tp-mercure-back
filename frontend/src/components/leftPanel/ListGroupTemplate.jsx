import Profile from "./Profile";

const ListGroupTemplate = ({ data }) => {
  const [dateFormated, other] = data.last_update.date.split(" ");
  return (
    <li className=" bg-white text-dark">
      <div className="w-full border-1 border-grey h-16 flex items-center justify-between px-4">
        <div className="flex items-center">
          <p>{data.data[1].username}</p>
        </div>
        <p className="truncate">{data.last_message.message}</p>
      </div>
    </li>
  );
};

export default ListGroupTemplate;
